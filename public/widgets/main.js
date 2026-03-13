(function () {
    // Simple widget loader for Smart Conversion Booster
    // Usage (Shopify theme):
    // <script src="https://YOUR_APP_DOMAIN/widgets/script.js?shop={{ shop.permanent_domain }}&productId={{ product.id }}" async></script>

    function getQueryParam(name) {
        const search = window.location.search;
        const params = new URLSearchParams(search);
        return params.get(name);
    }

    function createElement(tag, attrs = {}, content = '') {
        const el = document.createElement(tag);
        Object.entries(attrs).forEach(([key, value]) => {
            if (value === null || value === undefined) return;
            if (key === 'class') {
                el.className = value;
            } else if (key === 'style') {
                el.style.cssText = value;
            } else {
                el.setAttribute(key, value);
            }
        });
        if (typeof content === 'string') {
            el.innerHTML = content;
        } else if (content instanceof Node) {
            el.appendChild(content);
        }
        return el;
    }

    function safeText(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    const shop = getQueryParam('shop') || window.Shopify?.shop;
    const productId = getQueryParam('productId') || window.ShopifyAnalytics?.product?.id || (window.meta && window.meta.product && window.meta.product.id);

    if (!shop || !productId) {
        console.warn('[SCB] Missing shop or productId; reviews widget will not load.');
        return;
    }

    // Determine app origin from the loaded script's URL (not the store domain)
    const currentScript = document.currentScript || document.querySelector('script[src*="/widgets/script.js"]');
    const baseUrl = currentScript ? new URL(currentScript.src, window.location.href).origin : window.location.origin;
    const apiBase = `${baseUrl}/widgets`;

    const widgetRootId = 'scb-reviews-widget';

    function getRoot() {
        let root = document.getElementById(widgetRootId);
        if (!root) {
            root = createElement('div', { id: widgetRootId });
            document.body.appendChild(root);
        }
        return root;
    }

    function renderLoading() {
        const root = getRoot();
        root.innerHTML = '';
        root.appendChild(createElement('div', { class: 'scb-widget scb-loading' }, 'Loading reviews...'));
    }

    function renderError(message) {
        const root = getRoot();
        root.innerHTML = '';
        root.appendChild(createElement('div', { class: 'scb-widget scb-error' }, safeText(message)));
    }

    function renderReviews(data) {
        const root = getRoot();
        root.innerHTML = '';

        const title = createElement('div', { class: 'scb-widget__title' }, 'Customer Reviews');
        root.appendChild(title);

        const summary = createElement('div', { class: 'scb-widget__summary' });
        const avg = data.summary.averageRating || 0;
        const total = data.summary.totalReviews || 0;
        summary.innerHTML = `
            <span class="scb-widget__rating">${avg.toFixed(1)} ★</span>
            <span class="scb-widget__count">(${total} review${total === 1 ? '' : 's'})</span>
        `;
        root.appendChild(summary);

        if (!Array.isArray(data.reviews) || data.reviews.length === 0) {
            const empty = createElement('div', { class: 'scb-widget__empty' }, 'No reviews yet.');
            root.appendChild(empty);
            return;
        }

        const list = createElement('div', { class: 'scb-widget__list' });

        data.reviews.forEach((review) => {
            const item = createElement('div', { class: 'scb-widget__item' });

            const header = createElement('div', { class: 'scb-widget__item-header' });
            header.innerHTML = `
                <span class="scb-widget__author">${safeText(review.customer_name || 'Anonymous')}</span>
                <span class="scb-widget__stars">${'★'.repeat(Math.max(0, Math.min(5, review.rating || 0)))}</span>
            `;
            item.appendChild(header);

            if (review.title) {
                item.appendChild(createElement('div', { class: 'scb-widget__item-title' }, safeText(review.title)));
            }

            item.appendChild(createElement('div', { class: 'scb-widget__item-content' }, safeText(review.content || '')));

            list.appendChild(item);
        });

        root.appendChild(list);
    }

    async function load() {
        renderLoading();

        try {
            const configRes = await fetch(`${apiBase}/config?shop=${encodeURIComponent(shop)}`);
            if (!configRes.ok) {
                throw new Error('Failed to load widget configuration');
            }
            const config = await configRes.json();

            const enabled = config?.data?.reviews?.enabled;
            if (!enabled) {
                renderError('Reviews are currently disabled in the app settings.');
                return;
            }

            const reviewsRes = await fetch(`${apiBase}/reviews?shop=${encodeURIComponent(shop)}&productId=${encodeURIComponent(productId)}`);
            if (!reviewsRes.ok) {
                throw new Error('Failed to load reviews');
            }
            const reviewsData = await reviewsRes.json();
            renderReviews(reviewsData.data);
        } catch (err) {
            console.error('[SCB] Widget error:', err);
            renderError('Unable to load reviews right now.');
        }
    }

    // Load CSS if not already added
    (function injectStylesheet() {
        const id = 'scb-reviews-styles';
        if (document.getElementById(id)) return;
        const link = document.createElement('link');
        link.id = id;
        link.rel = 'stylesheet';
        link.href = `${baseUrl}/widgets/styles.css?shop=${encodeURIComponent(shop)}`;
        document.head.appendChild(link);
    })();

    load();
})();
