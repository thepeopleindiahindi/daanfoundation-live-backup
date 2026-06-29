#!/bin/bash
# Daan Foundation WordPress Page Import Script
# Usage: bash scripts/import-pages.sh

set -euo pipefail

# --------------------------------------------------
# 1. Ensure WP-CLI is available
# --------------------------------------------------
if ! command -v wp &> /dev/null; then
    echo "WP-CLI not found. Installing..."
    curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
    chmod +x wp-cli.phar
    sudo mv wp-cli.phar /usr/local/bin/wp
fi

# --------------------------------------------------
# 2. Create Categories
# --------------------------------------------------
echo "Creating blog categories..."
wp term create category "Impact" --description="Impact stories" --slug=impact 2>/dev/null || true
wp term create category "Campaigns" --description="Campaign updates" --slug=campaigns 2>/dev/null || true
wp term create category "Appeals" --description="Emergency appeals" --slug=appeals 2>/dev/null || true
wp term create category "News" --description="Foundation news" --slug=news 2>/dev/null || true

# --------------------------------------------------
# 3. Create Pages
# --------------------------------------------------
create_page() {
    local title="$1"
    local slug="$2"
    local template="$3"
    local id
    id=$(wp post create --post_type=page --post_title="$title" --post_name="$slug" --post_status=publish --porcelain 2>/dev/null || echo "")
    if [ -n "$id" ] && [ "$id" -gt 0 ] 2>/dev/null; then
        if [ "$template" != "default" ]; then
            wp post meta set "$id" _wp_page_template "$template" 2>/dev/null || true
        fi
        echo "Created page: $title ($slug) — ID $id, template: $template"
    else
        echo "Skipped or already exists: $title ($slug)"
    fi
}

echo ""
echo "=== Creating pages ==="

# --- Info Pages ---
create_page "About Us" "about" "tpl-sidebar-content.php"
create_page "Bank Details" "bank-details" "page-bank-details.php"
create_page "Contact" "contact" "page-contact.php"
create_page "Where We Work" "where-we-work" "page-where-we-work.php"

# --- Program Pages ---
create_page "Community Kitchen" "community-kitchen" "tpl-sidebar-content.php"
create_page "Eid Gifts" "eid-gifts" "tpl-sidebar-content.php"
create_page "Orphan Sponsorship" "orphan-sponsorship" "page-orphan-sponsorship.php"
create_page "Ramadan" "ramadan" "tpl-sidebar-content.php"
create_page "Water" "water" "page-water.php"
create_page "Winter Appeal" "winter-appeal" "tpl-sidebar-content.php"

# --- Our Work Pages ---
create_page "Annual Report" "our-work/annual-report" "default"
create_page "Charity in Action" "our-work/charity-in-action" "default"
create_page "Clothing Distribution" "our-work/clothing-distribution" "default"
create_page "Community Trust" "our-work/community-trust" "default"
create_page "Donation is Trust" "our-work/donation-is-trust" "default"
create_page "Educational Support" "our-work/educational-support" "default"
create_page "Empowering Livelihoods" "our-work/empowering-livelihoods" "default"
create_page "History" "our-work/history" "default"
create_page "Impact" "our-work/impact" "default"
create_page "Marriage Assistance" "our-work/marriage-assistance" "default"
create_page "Medical Assistance" "our-work/medical-assistance" "default"
create_page "Ration Kit Distribution" "our-work/ration-kit-distribution" "default"
create_page "Serving with Dignity" "our-work/serving-with-dignity" "default"
create_page "Supporting Women" "our-work/supporting-women" "default"
create_page "Why Transparency" "our-work/why-transparency" "default"

# --- Islamic Giving Pages ---
create_page "Fidya" "fidya" "tpl-sidebar-content.php"
create_page "Kaffarah" "kaffarah" "tpl-sidebar-content.php"
create_page "Sadaqah" "sadaqah" "tpl-sidebar-content.php"
create_page "Sadaqah Jariyah" "sadaqah-jariyah" "tpl-sidebar-content.php"
create_page "Zakat" "zakat" "tpl-sidebar-content.php"
create_page "Zakat al-Fitr" "zakat-al-fitr" "tpl-sidebar-content.php"
create_page "Zakat Calculator" "zakat-calculator" "page-zakat-calculator.php"

# --- Donate / Appeals Pages ---
create_page "Appeals" "appeals" "page-appeals.php"
create_page "Donate" "donate" "page-donate.php"
create_page "Where Most Needed" "where-most-needed" "tpl-sidebar-content.php"

# --- Homepage ---
create_page "Home" "home" "front-page.php"

# --------------------------------------------------
# 4. Set static front page
# --------------------------------------------------
echo ""
echo "=== Setting homepage ==="
wp option update show_on_front "page" 2>/dev/null || true
HOME_ID=$(wp post list --post_type=page --name=home --format=ids 2>/dev/null || echo "")
if [ -n "$HOME_ID" ]; then
    wp option update page_on_front "$HOME_ID" 2>/dev/null || true
    echo "Front page set to Home (ID: $HOME_ID)"
fi

# --------------------------------------------------
# 5. Set permalink structure
# --------------------------------------------------
echo ""
echo "=== Setting permalink structure ==="
wp rewrite structure '/%postname%/' 2>/dev/null || true
wp rewrite flush 2>/dev/null || true

# --------------------------------------------------
# 6. Create primary navigation menu
# --------------------------------------------------
echo ""
echo "=== Creating primary menu ==="
MENU_ID=$(wp menu create "Primary Menu" --porcelain 2>/dev/null || echo "")
if [ -n "$MENU_ID" ] && [ "$MENU_ID" -gt 0 ] 2>/dev/null; then
    echo "Menu created (ID: $MENU_ID)"

    add_menu_item() {
        local title="$1"
        local url="$2"
        wp menu item add-custom "$MENU_ID" "$title" "$url" 2>/dev/null || true
        echo "  Added: $title ($url)"
    }

    add_menu_item "Home" "/"
    add_menu_item "About Us" "/about"
    add_menu_item "Donate" "/donate"
    add_menu_item "Community Kitchen" "/community-kitchen"
    add_menu_item "Zakat" "/zakat"
    add_menu_item "Contact" "/contact"

    wp menu location assign "$MENU_ID" "primary" 2>/dev/null || true
    echo "Menu assigned to primary location"
else
    echo "Menu already exists, skipping creation."
fi

# --------------------------------------------------
# 7. Create sample blog posts
# --------------------------------------------------
echo ""
echo "=== Creating sample blog posts ==="

create_post() {
    local title="$1"
    local slug="$2"
    local category="$3"
    local content="$4"
    local cat_id
    cat_id=$(wp term list category --field=term_id --slug="$category" --format=ids 2>/dev/null || echo "")
    local id
    id=$(wp post create --post_type=post --post_title="$title" --post_name="$slug" --post_content="$content" --post_status=publish --porcelain 2>/dev/null || echo "")
    if [ -n "$id" ] && [ "$id" -gt 0 ] 2>/dev/null; then
        if [ -n "$cat_id" ]; then
            wp post term set "$id" category "$cat_id" 2>/dev/null || true
        fi
        echo "Created post: $title ($slug) — ID $id"
    else
        echo "Skipped or already exists: $title ($slug)"
    fi
}

create_post "Community Kitchen Serves 500,000 Meals" \
    "community-kitchen-serves-500k" \
    "Impact" \
    "<!-- wp:paragraph --><p>Our Community Kitchen program has reached a milestone of 500,000 meals served since its inception in 2020. Every day, we provide nutritious meals to those in need, ensuring no one goes to bed hungry.</p><!-- /wp:paragraph -->"

create_post "Ramadan Iftar Program 2026" \
    "ramadan-iftar-program-2026" \
    "Campaigns" \
    "<!-- wp:paragraph --><p>This Ramadan, our Iftar program is reaching thousands of fasting individuals across the community. Join us in spreading the blessings of the holy month.</p><!-- /wp:paragraph -->"

create_post "Winter Appeal: Protecting Lives" \
    "winter-appeal-protecting-lives" \
    "Appeals" \
    "<!-- wp:paragraph --><p>As temperatures drop, our Winter Appeal provides blankets, warm clothing, and shelter to vulnerable families. Your support can protect lives this winter.</p><!-- /wp:paragraph -->"

echo ""
echo "=== Import complete ==="
