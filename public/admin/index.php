<?php require_once __DIR__ . '/../public/api/admin-config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel - Daan Foundation</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="icon" type="image/svg+xml" href="/favicon.svg">
<style>
/* Toast notification */
.toast { position: fixed; top: 20px; right: 20px; z-index: 9999; padding: 12px 24px; border-radius: 8px; color: #fff; font-weight: 500; transform: translateX(120%); transition: transform 0.3s ease; }
.toast.show { transform: translateX(0); }
.toast.success { background: #059669; }
.toast.error { background: #dc2626; }
/* Modal overlay */
.modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 50; display: flex; align-items: center; justify-content: center; }
.modal-content { background: #fff; border-radius: 16px; padding: 24px; width: 90%; max-width: 800px; max-height: 90vh; overflow-y: auto; }
/* Content area styling */
#editor { min-height: 400px; }
/* File upload preview */
.upload-zone { border: 2px dashed #d1d5db; border-radius: 12px; padding: 40px; text-align: center; cursor: pointer; transition: all 0.2s; }
.upload-zone:hover { border-color: #ea580c; background: #fff7ed; }
.upload-zone.has-image { padding: 8px; border-style: solid; }
</style>
</head>
<body class="bg-gray-50 font-sans">
<div id="app"></div>

<!-- Toast container -->
<div id="toast" class="toast"></div>

<script>
const API_BASE = '/api';
let state = { view: 'login', posts: [], categories: [], tags: [], editPost: null };

function showToast(msg, type = 'success') {
    const t = document.getElementById('toast');
    t.textContent = msg; t.className = 'toast ' + type;
    setTimeout(() => t.classList.add('show'), 10);
    setTimeout(() => t.classList.remove('show'), 3000);
}

async function api(url, opts = {}) {
    const res = await fetch(API_BASE + url, {
        credentials: 'include',
        headers: { 'Content-Type': 'application/json', ...opts.headers },
        ...opts,
    });
    const data = await res.json();
    if (!data.success && res.status >= 400) throw new Error(data.message || 'Request failed');
    return data;
}

// ─── AUTH ─────────────────────────────────────────
async function checkAuth() {
    try { const d = await api('/check-auth.php'); return d.authenticated; }
    catch { return false; }
}

async function login(password) {
    await api('/login.php', { method: 'POST', body: JSON.stringify({ password }) });
}

async function logout() {
    await api('/logout.php');
    state.view = 'login'; render();
}

// ─── DATA FETCHING ────────────────────────────────
async function loadPosts() {
    const d = await api('/blog/posts.php?status=all&limit=100');
    state.posts = d.data; renderPosts();
}

async function loadCategories() {
    const d = await api('/blog/categories.php');
    state.categories = d.data;
}

async function loadTags() {
    const d = await api('/blog/tags.php');
    state.tags = d.data;
}

async function getPost(id) {
    const d = await api('/blog/posts.php?id=' + id);
    return d.data;
}

async function savePost(data) {
    const method = data.id ? 'PUT' : 'POST';
    await api('/blog/posts.php', { method, body: JSON.stringify(data) });
}

async function deletePost(id) {
    if (!confirm('Delete this post permanently?')) return;
    await api('/blog/posts.php?id=' + id, { method: 'DELETE' });
    loadPosts();
}

async function saveCategory(name) {
    const slug = name.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
    await api('/blog/categories.php', { method: 'POST', body: JSON.stringify({ name, slug }) });
    loadCategories(); loadPosts();
}

async function deleteCategory(id) {
    if (!confirm('Delete this category?')) return;
    await api('/blog/categories.php?id=' + id, { method: 'DELETE' });
    loadCategories();
}

// ─── IMAGE UPLOAD ─────────────────────────────────
async function uploadImage(file) {
    const formData = new FormData();
    formData.append('image', file);
    const res = await fetch(API_BASE + '/blog/upload.php', { method: 'POST', credentials: 'include', body: formData });
    const data = await res.json();
    if (!data.success) throw new Error(data.message);
    return data.url;
}

// ─── RENDER ───────────────────────────────────────
function render() {
    const app = document.getElementById('app');
    if (state.view === 'login') { renderLogin(); return; }
    app.innerHTML = `
        <div class="min-h-screen flex">
            ${renderSidebar()}
            <main class="flex-1 p-8" id="main-content">
                ${state.view === 'dashboard' ? '<div id="posts-section"></div>' : ''}
                ${state.view === 'editor' ? '<div id="editor-section"></div>' : ''}
                ${state.view === 'categories' ? '<div id="categories-section"></div>' : ''}
                ${state.view === 'settings' ? '<div id="settings-section"></div>' : ''}
            </main>
        </div>
    `;
    if (state.view === 'dashboard') renderPosts();
    if (state.view === 'editor') renderEditor();
    if (state.view === 'categories') renderCategories();
    if (state.view === 'settings') renderSettings();
}

function renderLogin() {
    document.getElementById('app').innerHTML = `
        <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-orange-50 to-amber-50">
            <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-md">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">Admin Login</h1>
                    <p class="text-gray-500 mt-1">Daan Foundation CMS</p>
                </div>
                <form onsubmit="handleLogin(event)" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" id="login-password" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                    </div>
                    <button type="submit" class="w-full bg-orange-600 text-white font-semibold py-2.5 rounded-lg hover:bg-orange-700 transition-colors">Sign In</button>
                </form>
            </div>
        </div>
    `;
}

function renderSidebar() {
    const links = [
        { view: 'dashboard', label: 'Posts', icon: '📝' },
        { view: 'editor', label: 'New Post', icon: '➕' },
        { view: 'categories', label: 'Categories', icon: '📂' },
        { view: 'settings', label: 'Settings', icon: '⚙️' },
    ];
    return `
        <aside class="w-64 bg-white border-r border-gray-200 min-h-screen p-6 flex flex-col">
            <div class="mb-8">
                <h2 class="text-lg font-bold text-gray-900">Daan CMS</h2>
                <p class="text-xs text-gray-400">Content Management</p>
            </div>
            <nav class="flex-1 space-y-1">
                ${links.map(l => `
                    <button onclick="navigate('${l.view}')"
                        class="w-full text-left px-4 py-2.5 rounded-lg text-sm font-medium transition-colors
                        ${state.view === l.view ? 'bg-orange-50 text-orange-700' : 'text-gray-600 hover:bg-gray-50'}">
                        ${l.icon} ${l.label}
                    </button>
                `).join('')}
            </nav>
            <button onclick="handleLogout()" class="text-sm text-gray-400 hover:text-red-500 mt-4 px-4 py-2">Sign Out</button>
        </aside>
    `;
}

function navigate(view) {
    state.view = view;
    if (view === 'editor') state.editPost = null;
    render();
}

// ─── DASHBOARD ────────────────────────────────────
function renderPosts() {
    const el = document.getElementById('posts-section');
    const posts = state.posts;
    el.innerHTML = `
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Blog Posts</h1>
            <button onclick="navigate('editor')" class="bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-orange-700">+ New Post</button>
        </div>
        ${posts.length === 0 ? '<p class="text-gray-400">No posts yet.</p>' : `
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="text-left px-4 py-3 font-semibold text-gray-600">Title</th>
                        <th class="text-left px-4 py-3 font-semibold text-gray-600 hidden md:table-cell">Category</th>
                        <th class="text-left px-4 py-3 font-semibold text-gray-600 hidden sm:table-cell">Status</th>
                        <th class="text-left px-4 py-3 font-semibold text-gray-600 hidden lg:table-cell">Date</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    ${posts.map(p => `
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-900">${escHtml(p.title)}</td>
                        <td class="px-4 py-3 text-gray-500 hidden md:table-cell">${escHtml(p.category_name || '-')}</td>
                        <td class="px-4 py-3 hidden sm:table-cell">
                            <span class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold ${p.status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'}">${p.status}</span>
                            ${p.featured ? '<span class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 ml-1">Featured</span>' : ''}
                        </td>
                        <td class="px-4 py-3 text-gray-500 hidden lg:table-cell">${p.published_at ? new Date(p.published_at).toLocaleDateString() : '-'}</td>
                        <td class="px-4 py-3 text-right">
                            <button onclick="editPost(${p.id})" class="text-orange-600 hover:text-orange-800 font-medium mr-3">Edit</button>
                            <button onclick="deletePost(${p.id})" class="text-red-500 hover:text-red-700 font-medium">Delete</button>
                        </td>
                    </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>`}
    `;
}

// ─── EDITOR ───────────────────────────────────────
function renderEditor() {
    const el = document.getElementById('editor-section');
    const post = state.editPost || {};
    el.innerHTML = `
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">${post.id ? 'Edit Post' : 'New Post'}</h1>
            ${post.id ? `<button onclick="previewPost()" class="text-orange-600 text-sm font-medium">Preview →</button>` : ''}
        </div>
        <form id="post-form" onsubmit="handleSavePost(event)" class="space-y-6 max-w-4xl">
            <input type="hidden" name="id" value="${post.id || ''}">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                        <input type="text" name="title" required
                            value="${escHtml(post.title || '')}"
                            oninput="generateSlug(this.value)"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-lg font-medium">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                        <input type="text" name="slug" id="post-slug"
                            value="${escHtml(post.slug || '')}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-sm text-gray-500 font-mono">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Excerpt</label>
                        <textarea name="excerpt" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">${escHtml(post.excerpt || '')}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Content (HTML)</label>
                        <textarea name="content" id="editor" rows="20" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none font-mono text-sm">${escHtml(post.content || '')}</textarea>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                            <option value="draft" ${post.status === 'draft' ? 'selected' : ''}>Draft</option>
                            <option value="published" ${post.status === 'published' ? 'selected' : ''}>Published</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category_id" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                            <option value="">— None —</option>
                            ${state.categories.map(c => `<option value="${c.id}" ${post.category_id == c.id ? 'selected' : ''}>${escHtml(c.name)}</option>`).join('')}
                        </select>
                        <div class="mt-2 flex gap-2">
                            <input type="text" id="new-cat" placeholder="Add category..." class="flex-1 px-3 py-1.5 text-sm border rounded-lg focus:ring-2 focus:ring-orange-500 outline-none">
                            <button type="button" onclick="addQuickCategory()" class="text-sm text-orange-600 font-medium hover:text-orange-700">Add</button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tags</label>
                        <div id="tags-container" class="flex flex-wrap gap-1 mb-2">
                            ${(post.tags || []).map(t => `<span class="inline-flex items-center gap-1 px-2 py-1 bg-orange-50 text-orange-700 rounded-full text-xs font-medium">${escHtml(t)} <button type="button" onclick="removeTag(this)" class="text-orange-400 hover:text-orange-600">×</button></span>`).join('')}
                        </div>
                        <div class="flex gap-2">
                            <input type="text" id="new-tag" placeholder="Add tag..." class="flex-1 px-3 py-1.5 text-sm border rounded-lg focus:ring-2 focus:ring-orange-500 outline-none">
                            <button type="button" onclick="addQuickTag()" class="text-sm text-orange-600 font-medium hover:text-orange-700">Add</button>
                        </div>
                        <input type="hidden" name="tags" id="tags-input" value='${JSON.stringify(post.tags || [])}'>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Author</label>
                        <input type="text" name="author" value="${escHtml(post.author || 'Daan Foundation Team')}" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none">
                    </div>
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700">
                            <input type="checkbox" name="featured" value="1" ${post.featured ? 'checked' : ''} class="rounded">
                            Featured post
                        </label>
                    </div>

                    <!-- Featured image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Featured Image</label>
                        <div class="upload-zone" id="upload-zone" onclick="document.getElementById('file-input').click()">
                            <div id="upload-placeholder">
                                <p class="text-gray-400 text-sm">Click to upload image</p>
                                <p class="text-gray-300 text-xs mt-1">JPG, PNG, WebP up to 5MB</p>
                            </div>
                            <div id="upload-preview" class="${post.featured_image ? '' : 'hidden'}">
                                <img id="upload-preview-img" src="${post.featured_image || ''}" class="max-h-48 mx-auto rounded-lg">
                                <p class="text-xs text-gray-400 mt-2">Click to change</p>
                            </div>
                        </div>
                        <input type="file" id="file-input" accept="image/*" class="hidden" onchange="handleFileUpload(this)">
                        <input type="hidden" name="featured_image" id="featured-image-input" value="${escHtml(post.featured_image || '')}">
                    </div>

                    <!-- SEO -->
                    <details class="text-sm">
                        <summary class="cursor-pointer text-gray-500 font-medium">SEO Settings</summary>
                        <div class="mt-3 space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">SEO Title</label>
                                <input type="text" name="seo_title" value="${escHtml(post.seo_title || '')}" class="w-full px-3 py-1.5 border rounded-lg text-sm focus:ring-2 focus:ring-orange-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Meta Description</label>
                                <textarea name="seo_description" rows="2" class="w-full px-3 py-1.5 border rounded-lg text-sm focus:ring-2 focus:ring-orange-500 outline-none">${escHtml(post.seo_description || '')}</textarea>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Keywords (comma separated)</label>
                                <input type="text" name="seo_keywords" value="${escHtml(post.seo_keywords || '')}" class="w-full px-3 py-1.5 border rounded-lg text-sm focus:ring-2 focus:ring-orange-500 outline-none">
                            </div>
                        </div>
                    </details>

                    <button type="submit" class="w-full bg-orange-600 text-white font-semibold py-2.5 rounded-lg hover:bg-orange-700 transition-colors">
                        ${post.id ? 'Update Post' : 'Publish Post'}
                    </button>
                </div>
            </div>
        </form>
    `;
}

// ─── CATEGORIES ───────────────────────────────────
function renderCategories() {
    const el = document.getElementById('categories-section');
    el.innerHTML = `
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Categories</h1>
        <div class="bg-white rounded-xl shadow-sm p-6 max-w-2xl">
            <form onsubmit="handleAddCategory(event)" class="flex gap-2 mb-6">
                <input type="text" id="category-name" placeholder="Category name..." required
                    class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none">
                <button type="submit" class="bg-orange-600 text-white px-4 py-2.5 rounded-lg font-medium hover:bg-orange-700">Add</button>
            </form>
            <div class="space-y-2">
                ${state.categories.map(c => `
                    <div class="flex items-center justify-between px-4 py-3 bg-gray-50 rounded-lg">
                        <div>
                            <span class="font-medium text-gray-900">${escHtml(c.name)}</span>
                            <span class="text-xs text-gray-400 ml-2">${c.post_count || 0} posts</span>
                        </div>
                        <button onclick="deleteCategory(${c.id})" class="text-red-400 hover:text-red-600 text-sm">Delete</button>
                    </div>
                `).join('')}
                ${state.categories.length === 0 ? '<p class="text-gray-400 text-sm">No categories yet.</p>' : ''}
            </div>
        </div>
    `;
}

function renderSettings() {
    document.getElementById('settings-section').innerHTML = `
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Settings</h1>
        <div class="bg-white rounded-xl shadow-sm p-6 max-w-2xl space-y-6">
            <div>
                <h2 class="font-semibold text-gray-900 mb-2">Sitemap</h2>
                <p class="text-sm text-gray-500 mb-2">Your XML sitemap is available at:</p>
                <a href="/api/sitemap.php" target="_blank" class="text-orange-600 text-sm font-mono hover:underline">/api/sitemap.php</a>
            </div>
            <div>
                <h2 class="font-semibold text-gray-900 mb-2">RSS Feed</h2>
                <p class="text-sm text-gray-500 mb-2">Your RSS feed is available at:</p>
                <a href="/api/rss.php" target="_blank" class="text-orange-600 text-sm font-mono hover:underline">/api/rss.php</a>
            </div>
            <div>
                <h2 class="font-semibold text-gray-900 mb-2">Database Setup</h2>
                <p class="text-sm text-gray-500 mb-2">Run this to create/update blog tables:</p>
                <a href="/api/blog/setup.php" target="_blank" class="text-orange-600 text-sm font-mono hover:underline">/api/blog/setup.php</a>
            </div>
        </div>
    `;
}

// ─── HANDLERS ─────────────────────────────────────
window.handleLogin = async function(e) {
    e.preventDefault();
    const pw = document.getElementById('login-password').value;
    try {
        await login(pw);
        state.view = 'dashboard';
        await Promise.all([loadPosts(), loadCategories(), loadTags()]);
        render();
        showToast('Welcome back!');
    } catch (err) {
        showToast(err.message || 'Invalid password', 'error');
    }
};

window.handleLogout = async function() {
    await logout();
};

window.handleSavePost = async function(e) {
    e.preventDefault();
    const form = e.target;
    const data = Object.fromEntries(new FormData(form));
    data.featured = form.featured?.checked ? 1 : 0;
    try {
        const tags = document.getElementById('tags-input')?.value;
        data.tags = tags ? JSON.parse(tags) : [];
        await savePost(data);
        showToast(data.id ? 'Post updated!' : 'Post created!');
        state.view = 'dashboard';
        await loadPosts();
        render();
    } catch (err) {
        showToast(err.message || 'Save failed', 'error');
    }
};

window.generateSlug = function(title) {
    const slugInput = document.getElementById('post-slug');
    if (!slugInput.dataset.manual) {
        slugInput.value = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
    }
};

window.handleFileUpload = async function(input) {
    const file = input.files[0];
    if (!file) return;
    try {
        const url = await uploadImage(file);
        document.getElementById('featured-image-input').value = url;
        document.getElementById('upload-preview-img').src = url;
        document.getElementById('upload-placeholder').classList.add('hidden');
        document.getElementById('upload-preview').classList.remove('hidden');
        document.getElementById('upload-zone').classList.add('has-image');
        showToast('Image uploaded!');
    } catch (err) {
        showToast(err.message || 'Upload failed', 'error');
    }
};

window.addQuickTag = function() {
    const input = document.getElementById('new-tag');
    const val = input.value.trim();
    if (!val) return;
    const tags = JSON.parse(document.getElementById('tags-input').value || '[]');
    if (!tags.includes(val)) {
        tags.push(val);
        document.getElementById('tags-input').value = JSON.stringify(tags);
        const container = document.getElementById('tags-container');
        const span = document.createElement('span');
        span.className = 'inline-flex items-center gap-1 px-2 py-1 bg-orange-50 text-orange-700 rounded-full text-xs font-medium';
        span.innerHTML = escHtml(val) + ' <button type="button" onclick="removeTag(this)" class="text-orange-400 hover:text-orange-600">×</button>';
        container.appendChild(span);
    }
    input.value = '';
};

window.removeTag = function(btn) {
    const span = btn.parentElement;
    const name = span.textContent.slice(0, -1);
    span.remove();
    const tags = JSON.parse(document.getElementById('tags-input').value || '[]');
    document.getElementById('tags-input').value = JSON.stringify(tags.filter(t => t !== name));
};

window.addQuickCategory = async function() {
    const input = document.getElementById('new-cat');
    const val = input.value.trim();
    if (!val) return;
    try {
        await saveCategory(val);
        input.value = '';
        // Refresh the select
        const selects = document.querySelectorAll('select[name="category_id"]');
        selects.forEach(sel => {
            const current = sel.value;
            sel.innerHTML = '<option value="">— None —</option>' + state.categories.map(c => `<option value="${c.id}">${escHtml(c.name)}</option>`).join('');
            sel.value = current;
        });
        showToast('Category added!');
    } catch (err) {
        showToast(err.message, 'error');
    }
};

window.handleAddCategory = async function(e) {
    e.preventDefault();
    const input = document.getElementById('category-name');
    try {
        await saveCategory(input.value);
        input.value = '';
        showToast('Category added!');
    } catch (err) {
        showToast(err.message, 'error');
    }
};

window.editPost = async function(id) {
    try {
        state.editPost = await getPost(id);
        state.view = 'editor';
        render();
    } catch (err) {
        showToast(err.message, 'error');
    }
};

window.previewPost = function() {
    const slug = state.editPost?.slug;
    if (slug) window.open('/news/' + slug, '_blank');
};

// ─── UTILITIES ────────────────────────────────────
function escHtml(str) {
    if (!str) return '';
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

// ─── INIT ─────────────────────────────────────────
(async function init() {
    const authed = await checkAuth();
    if (authed) {
        state.view = 'dashboard';
        await Promise.all([loadPosts(), loadCategories(), loadTags()]);
        render();
    } else {
        render();
    }
})();
</script>
</body>
</html>
