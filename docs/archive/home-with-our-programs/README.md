# Homepage with the "Our Programs" section

`front-page.php` here is the homepage template as it was before "Our Programs" was removed on 2026-11-04 (owner request). It is a reference copy; WordPress does not load it.

## How to bring the section back

1. Open this `front-page.php` and find the block marked `OUR PROGRAMS` (it holds `<h2>Our Programs</h2>`), up to its closing `</section>`.
2. Paste that block into `wp-content/themes/daan-custom/front-page.php`, between the "Emergency Appeal" section and the "Serving Humanity With Compassion Since 2020" section.
3. Do not copy the whole file: it is an older homepage and would undo later changes.
4. Back up, upload by FTP/SSH and check the homepage at 375, 1024 and 1440 px.
