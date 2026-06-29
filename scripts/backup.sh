#!/bin/bash
# ──────────────────────────────────────────────────────────────────────────────
# Daan Foundation — Automated WordPress Backup
# Schedule via cron (e.g. daily at 02:00):
#   0 2 * * * /var/www/daan/scripts/backup.sh >> /var/log/daan-backup.log 2>&1
# ──────────────────────────────────────────────────────────────────────────────
set -euo pipefail

BACKUP_DIR="backup/$(date +%F-%H%M)"
mkdir -p "$BACKUP_DIR"

echo "=== Daan Foundation Backup : $(date) ==="

# ── 1. Database dump via WP-CLI ────────────────────────────────────────────
echo "Backing up database..."
wp db export "$BACKUP_DIR/database.sql" --add-drop-table

# ── 2. WordPress files (exclude uploads cache) ─────────────────────────────
echo "Backing up wp-content..."
rsync -a wp-content/ "$BACKUP_DIR/wp-content/" --exclude=uploads/cache

# ── 3. Config files ────────────────────────────────────────────────────────
cp wp-config.php "$BACKUP_DIR/"
cp .htaccess "$BACKUP_DIR/"

# ── 4. Archive ─────────────────────────────────────────────────────────────
echo "Creating archive..."
cd backup
tar czf "$(basename "$BACKUP_DIR").tar.gz" "$(basename "$BACKUP_DIR")"
rm -rf "$(basename "$BACKUP_DIR")"

# ── 5. Rotate — keep last 7 backups ───────────────────────────────────────
ls -t *.tar.gz | tail -n +8 | xargs -r rm

echo "=== Backup complete: backup/$(basename "$BACKUP_DIR").tar.gz ==="

# ── 6. (Optional) Remote upload — uncomment and configure as needed ────────
# echo "Uploading to remote storage..."
# aws s3 cp "backup/$(basename "$BACKUP_DIR").tar.gz" "s3://daan-backups/"
# scp "backup/$(basename "$BACKUP_DIR").tar.gz" user@remote:/path/to/backups/
