#!/bin/bash
set -euo pipefail

echo "═══════════════════════════════════════════"
echo "  Daan Foundation — Rollback"
echo "  $(date)"
echo "═══════════════════════════════════════════"

SITE_ROOT="/path/to/public_html"
BACKUP_DIR="$SITE_ROOT/backups"
DOMAIN="daanfoundation.in"

# Find latest backup
LATEST=$(ls -t "$BACKUP_DIR/"*.sql 2>/dev/null | head -1)
if [ -z "$LATEST" ]; then
    echo "ERROR: No backup found in $BACKUP_DIR"
    exit 1
fi

echo "Restoring from: $LATEST"
echo ""

echo "[1/3] Enabling maintenance..."
touch "$SITE_ROOT/.maintenance"

echo "[2/3] Restoring database..."
wp db reset --yes
wp db import "$LATEST"

echo "[3/3] Restoring old .htaccess (React app)..."
OLD_HTACCESS="$BACKUP_DIR/.htaccess.react-backup"
if [ -f "$OLD_HTACCESS" ]; then
    cp "$OLD_HTACCESS" "$SITE_ROOT/.htaccess"
else
    echo "WARNING: Old .htaccess not found. Re-creating React rewrite rules..."
    cat > "$SITE_ROOT/.htaccess" << 'HTACCESS'
DirectoryIndex index.html index.php
RewriteEngine On
RewriteBase /
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.html [L]
HTACCESS
fi

echo "[3/3] Verifying..."
curl -s -o /dev/null -w "Status: %{http_code}\n" "https://$DOMAIN/" || echo "CHECK FAILED"

rm -f "$SITE_ROOT/.maintenance"
echo ""
echo "✅ Rollback complete. React app is live again."
