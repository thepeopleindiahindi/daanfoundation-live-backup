/**
 * Daan Foundation — Daily Blog Publisher
 *
 * Usage:
 *   node scripts/publish-blog.js <path-to-article.json>
 *
 * Article JSON fields:
 *   title, slug, content (HTML), excerpt, category_name or category_id,
 *   tags[], featured_image, seo_title, seo_description, seo_keywords,
 *   author, status, featured
 *
 * Options:
 *   --check-image    Verify featured_image file exists locally before publishing
 */

import { readFileSync, existsSync } from 'fs';
import { join, dirname } from 'path';
import { fileURLToPath } from 'url';

const __dirname = dirname(fileURLToPath(import.meta.url));
const BASE_URL = 'https://daanfoundation.in';

// ── Read ADMIN_PASSWORD from .env (never hardcoded) ──
const ADMIN_PASSWORD = (() => {
  try {
    const envPath = join(__dirname, '..', '.env');
    const envContent = readFileSync(envPath, 'utf-8');
    for (const line of envContent.split('\n')) {
      const trimmed = line.trim();
      if (trimmed.startsWith('ADMIN_PASSWORD=')) {
        let val = trimmed.slice('ADMIN_PASSWORD='.length);
        if ((val.startsWith("'") && val.endsWith("'")) || (val.startsWith('"') && val.endsWith('"'))) {
          val = val.slice(1, -1);
        }
        return val;
      }
    }
  } catch (_) { /* .env not found */ }
  console.error('ADMIN_PASSWORD not found in .env file.');
  console.error('Create .env in project root with: ADMIN_PASSWORD=your_password');
  process.exit(1);
})();

async function main() {
  const args = process.argv.slice(2);
  if (args.length === 0 || args[0] === '--help') {
    console.log('Usage: node scripts/publish-blog.js <article.json> [--check-image]');
    console.log('  --check-image  Verify featured_image file exists in public/images/');
    process.exit(0);
  }

  const articlePath = args[0];
  const checkImage = args.includes('--check-image');

  // Read article data
  const article = JSON.parse(readFileSync(articlePath, 'utf-8'));
  console.log(`\n=== Publishing: "${article.title}" ===\n`);

  // Optional: check image exists locally
  if (checkImage && article.featured_image) {
    const localPath = join(__dirname, '..', 'public', article.featured_image);
    if (existsSync(localPath)) {
      console.log(`  Featured image found: ${article.featured_image}`);
    } else {
      console.log(`  Featured image MISSING: ${localPath}`);
      console.log('  Aborting. Upload the image first or update the path.');
      process.exit(1);
    }
  }

  // Step 1: Login
  console.log('  1. Logging in to admin API...');
  const loginRes = await fetch(`${BASE_URL}/api/login.php`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ password: ADMIN_PASSWORD }),
    redirect: 'manual',
  });

  const loginData = await loginRes.json();
  if (!loginData.success) {
    console.log(`  Login failed: ${loginData.message}`);
    process.exit(1);
  }

  const setCookie = loginRes.headers.get('set-cookie');
  if (!setCookie) {
    console.log('  No auth cookie received from server');
    process.exit(1);
  }
  const cookie = setCookie.split(';')[0];
  console.log('  Login successful');

  // Step 2: Check slug doesn't already exist
  const slugCheckRes = await fetch(`${BASE_URL}/api/blog/posts.php?slug=${encodeURIComponent(article.slug)}`);
  if (slugCheckRes.ok) {
    const slugCheckData = await slugCheckRes.json();
    if (slugCheckData.success && slugCheckData.data) {
      const existing = slugCheckData.data;
      console.log(`  Existing post found with slug "${article.slug}" (ID: ${existing.id}, status: ${existing.status})`);
      console.log(`  Deleting existing post...`);
      const delRes = await fetch(`${BASE_URL}/api/blog/posts.php?id=${existing.id}`, {
        method: 'DELETE',
        headers: { Cookie: cookie },
      });
      if (delRes.ok) {
        console.log(`  Deleted post ID ${existing.id}`);
      } else {
        console.log(`  Failed to delete existing post`);
        process.exit(1);
      }
    }
  }

  // Step 3: Build post body
  const body = {
    title: article.title,
    slug: article.slug,
    excerpt: article.excerpt || '',
    content: article.content,
    featured_image: article.featured_image || '',
    category_id: article.category_id || null,
    author: article.author || 'Daan Foundation Team',
    seo_title: article.seo_title || article.title,
    seo_description: article.seo_description || article.excerpt || '',
    seo_keywords: article.seo_keywords || '',
    status: article.status || 'published',
    featured: article.featured || 0,
    tags: article.tags || [],
  };

  // Step 3a: Resolve category by name if provided
  if (article.category_name && !article.category_id) {
    console.log(`  3a. Looking up category: "${article.category_name}"...`);
    const catRes = await fetch(`${BASE_URL}/api/blog/categories.php`, {
      headers: { Cookie: cookie },
    });
    const catData = await catRes.json();
    const found = catData.data?.find(
      c => c.name === article.category_name || c.slug === article.category_name.toLowerCase().replace(/\s+/g, '-')
    );
    if (found) {
      body.category_id = found.id;
      console.log(`  Using existing category: "${found.name}" (ID: ${found.id})`);
    } else {
      const createCatRes = await fetch(`${BASE_URL}/api/blog/categories.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', Cookie: cookie },
        body: JSON.stringify({ name: article.category_name }),
      });
      const createCatData = await createCatRes.json();
      if (createCatData.success) {
        body.category_id = createCatData.id;
        console.log(`  Created new category: "${article.category_name}" (ID: ${createCatData.id})`);
      } else {
        console.log(`  Could not create category, proceeding without one`);
        body.category_id = null;
      }
    }
  }

  // Step 4: Create post
  console.log('  4. Creating blog post...');
  const postRes = await fetch(`${BASE_URL}/api/blog/posts.php`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', Cookie: cookie },
    body: JSON.stringify(body),
  });

  const postData = await postRes.json();
  if (!postData.success) {
    console.log(`  Post creation failed: ${postData.message}`);
    process.exit(1);
  }

  const postId = postData.id;
  const postUrl = `${BASE_URL}/news/${article.slug}`;
  console.log(`  Post created! ID: ${postId}`);
  console.log(`  ${postUrl}`);

  // Step 5: Verify post is accessible
  console.log('  5. Verifying post is accessible...');
  const verifyRes = await fetch(`${BASE_URL}/api/blog/posts.php?slug=${encodeURIComponent(article.slug)}`);
  if (verifyRes.ok) {
    const verifyData = await verifyRes.json();
    if (verifyData.success && verifyData.data) {
      console.log(`  Post verified on server`);
      console.log(`  Published: ${verifyData.data.published_at || 'just now'}`);
      console.log(`  Category: ${verifyData.data.category_name || 'N/A'}`);
      console.log(`  Tags: ${(verifyData.data.tags || []).join(', ') || 'none'}`);
    }
  } else {
    console.log(`  Verification request failed (${verifyRes.status})`);
  }

  console.log(`\n=== Done ===\n`);
}

main().catch(err => {
  console.error('Script failed:', err.message);
  process.exit(1);
});
