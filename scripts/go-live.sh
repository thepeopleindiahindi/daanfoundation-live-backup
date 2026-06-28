#!/bin/bash
set -euo pipefail

echo "═══════════════════════════════════════════"
echo "  Daan Foundation — Go-Live Deployment"
echo "  $(date)"
echo "═══════════════════════════════════════════"

# ---- CONFIG ----
SITE_ROOT="/path/to/public_html"
OLD_BUILD="$SITE_ROOT/react-app"           # current React build location
NEW_WP="$SITE_ROOT/wp"                      # new WordPress installation
BACKUP_DIR="$SITE_ROOT/backups/pre-go-live"
DOMAIN="daanfoundation.in"
ADMIN_EMAIL="daanfoundationindia@gmail.com"

# ---- 1. PRE-FLIGHT CHECKS ----
echo ""
echo "[1/6] Running pre-flight checks..."

# Check WP-CLI
command -v wp >/dev/null 2>&1 || { echo "ERROR: WP-CLI not found"; exit 1; }
# Check PHP version
php -v | head -1
# Check MySQL connection
wp db check 2>/dev/null || { echo "ERROR: Database connection failed"; exit 1; }
# Verify .env keys are set
wp config has RAZORPAY_KEY_ID || echo "WARNING: RAZORPAY_KEY_ID not set in wp-config"
wp config has SMTP_HOST || echo "WARNING: SMTP not configured — emails may go to spam"

# ---- 2. FULL BACKUP ----
echo ""
echo "[2/6] Creating full pre-deployment backup..."
mkdir -p "$BACKUP_DIR"
wp db export "$BACKUP_DIR/database-$(date +%F-%H%M).sql"
cp -a . "$BACKUP_DIR/files/" 2>/dev/null || rsync -a . "$BACKUP_DIR/files/"
echo "Backup saved to: $BACKUP_DIR"

# ---- 3. ENABLE MAINTENANCE MODE ----
echo ""
echo "[3/6] Enabling maintenance mode..."
touch "$SITE_ROOT/.maintenance"
cat > "$SITE_ROOT/maintenance.php" << 'MAINT'
<?php
// Temporary maintenance page during cutover
header('HTTP/1.1 503 Service Temporarily Unavailable');
header('Retry-After: 600');
?>
<!DOCTYPE html>
<html><head><title>Under Maintenance</title>
<style>body{font-family:sans-serif;display:flex;justify-content:center;align-items:center;height:100vh;background:#F97316;color:white;text-align:center}
h1{font-size:2.5rem} p{font-size:1.2rem;opacity:0.9}</style></head>
<body><div><h1>&#x1f504; Site Update in Progress</h1>
<p>Daan Foundation is being updated. We'll be back in a few minutes.</p></div></body></html>
MAINT

# ---- 4. DEPLOY WORDPRESS ----
echo ""
echo "[4/6] Deploying WordPress..."

# Move new WP files to live root
# Option A: Symlink (preferred — instant rollback)
ln -sfn "$NEW_WP/wp-content" "$SITE_ROOT/wp-content"
ln -sfn "$NEW_WP/wp-config.php" "$SITE_ROOT/wp-config.php"
ln -sfn "$NEW_WP/index.php" "$SITE_ROOT/index.php"
ln -sfn "$NEW_WP/wp-admin" "$SITE_ROOT/wp-admin"
ln -sfn "$NEW_WP/wp-includes" "$SITE_ROOT/wp-includes"
ln -sfn "$NEW_WP/.htaccess" "$SITE_ROOT/.htaccess"
ln -sfn "$NEW_WP/robots.txt" "$SITE_ROOT/robots.txt"
ln -sfn "$NEW_WP/sitemap.xml" "$SITE_ROOT/sitemap.xml" 2>/dev/null || true

# Option B: Direct copy (use if symlinks not possible)
# rsync -a "$NEW_WP/" "$SITE_ROOT/" --exclude=node_modules --exclude=.git

# Copy uploaded images from old site
rsync -a "$SITE_ROOT/images/" "$SITE_ROOT/wp-content/uploads/" 2>/dev/null || true

# ---- 5. PERMALINKS & REDIRECTS ----
echo ""
echo "[5/6] Configuring permalinks and redirects..."

# Set permalink structure
wp rewrite structure '/%postname%/' --hard
wp rewrite flush

# Apply 301 redirect map
echo "301 redirects are handled by .htaccess (see backup/.htaccess-wp)"

# Set homepage as front page
wp option update show_on_front 'page'
wp option update page_on_front $(wp post list --post_type=page --name=home --format=ids 2>/dev/null || echo 0)
wp option update page_for_posts $(wp post list --post_type=page --name=news --format=ids 2>/dev/null || echo 0)

# ---- 6. VERIFICATION ----
echo ""
echo "[6/6] Running post-deployment checks..."

# Check all pages return 200
PAGES=$(wp post list --post_type=page --fields=url --format=csv 2>/dev/null | tail -n +5 || true)
for page in $PAGES; do
    STATUS=$(curl -s -o /dev/null -w "%{http_code}" "https://$DOMAIN/$page" 2>/dev/null || echo "000")
    if [ "$STATUS" != "200" ]; then
        echo "WARNING: $page returned $STATUS"
    fi
done

# Disable maintenance mode
rm -f "$SITE_ROOT/.maintenance" "$SITE_ROOT/maintenance.php"

echo ""
echo "═══════════════════════════════════════════"
echo "  ✅ Go-Live Complete!"
echo "  Verify at: https://$DOMAIN"
echo "  Rollback:  bash scripts/rollback.sh"
echo "  Backup at: $BACKUP_DIR"
echo "═══════════════════════════════════════════"
