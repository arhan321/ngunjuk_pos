const categoryTabs = document.querySelector('#categoryTabs');
const productGrid = document.querySelector('#productGrid');
const menuTitle = document.querySelector('#menuTitle');
const searchInput = document.querySelector('#searchInput');

const openCart = document.querySelector('#openCart');
const closeCart = document.querySelector('#closeCart');
const cartDrawer = document.querySelector('#cartDrawer');
const cartBackdrop = document.querySelector('#cartBackdrop');

const cartList = document.querySelector('#cartList');
const cartCount = document.querySelector('#cartCount');
const itemsTotal = document.querySelector('#itemsTotal');
const grandTotal = document.querySelector('#grandTotal');
const placeOrder = document.querySelector('#placeOrder');
const toast = document.querySelector('#toast');

const checkoutConfirmBackdrop = document.querySelector('#checkoutConfirmBackdrop');
const checkoutConfirmModal = document.querySelector('#checkoutConfirmModal');
const confirmTotalItem = document.querySelector('#confirmTotalItem');
const confirmTotalPrice = document.querySelector('#confirmTotalPrice');
const confirmOrderItems = document.querySelector('#confirmOrderItems');
const cancelCheckout = document.querySelector('#cancelCheckout');
const confirmCheckout = document.querySelector('#confirmCheckout');

const checkoutSuccessBackdrop = document.querySelector('#checkoutSuccessBackdrop');
const checkoutSuccessModal = document.querySelector('#checkoutSuccessModal');
const successOrderCode = document.querySelector('#successOrderCode');
const successTotalItem = document.querySelector('#successTotalItem');
const successTotalPrice = document.querySelector('#successTotalPrice');
const successOrderItems = document.querySelector('#successOrderItems');
const successStayPos = document.querySelector('#successStayPos');
const successGoHistory = document.querySelector('#successGoHistory');
const successPrintReceipt = document.querySelector('#successPrintReceipt');

let products = [];
let categories = [];
let activeCategory = '';
let cart = [];
let lastSavedOrder = null;

const formatRupiah = value => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    maximumFractionDigits: 0
  }).format(Number(value || 0));
};

const escapeHTML = value => {
  return String(value ?? '')
    .replaceAll('&', '&amp;')
    .replaceAll('<', '&lt;')
    .replaceAll('>', '&gt;')
    .replaceAll('"', '&quot;')
    .replaceAll("'", '&#039;');
};

const formatReceiptDateTime = value => {
  if (!value) {
    return '-';
  }

  const date = new Date(String(value).replace(' ', 'T'));

  if (Number.isNaN(date.getTime())) {
    return escapeHTML(value);
  }

  return new Intl.DateTimeFormat('id-ID', {
    day: '2-digit',
    month: 'short',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  }).format(date);
};

const showToast = message => {
  if (!toast) {
    return;
  }

  toast.textContent = message;
  toast.classList.add('show');

  setTimeout(() => {
    toast.classList.remove('show');
  }, 2200);
};

const openCartDrawer = () => {
  cartDrawer?.classList.add('show');
  cartBackdrop?.classList.add('show');
};

const closeCartDrawer = () => {
  cartDrawer?.classList.remove('show');
  cartBackdrop?.classList.remove('show');
};

const closeCheckoutSuccessModal = () => {
  checkoutSuccessModal?.classList.remove('show');
  checkoutSuccessBackdrop?.classList.remove('show');
};

const closeCheckoutConfirmModal = () => {
  checkoutConfirmModal?.classList.remove('show');
  checkoutConfirmBackdrop?.classList.remove('show');
};

const renderModalOrderItems = (items, type = 'confirm') => {
  if (!Array.isArray(items) || items.length === 0) {
    return `
      <div class="${type}-items-empty">
        Belum ada pesanan.
      </div>
    `;
  }

  return `
    <div class="${type}-items-head">
      <span>Pesanan</span>
      <strong>${items.length} menu</strong>
    </div>

    <div class="${type}-items-list">
      ${items.map(item => {
        const productName = item.name || item.product_name || '-';
        const sizeName = item.size || item.size_name || 'Regular';
        const quantity = Number(item.quantity || 0);
        const price = Number(item.price || 0);
        const subtotal = Number(item.subtotal || price * quantity);
        const note = item.note ? escapeHTML(item.note) : '';

        return `
          <div class="${type}-item-card">
            <div class="${type}-item-main">
              <div>
                <strong>${escapeHTML(productName)}</strong>
                <span>${escapeHTML(sizeName)} • x${quantity}</span>
              </div>

              <b>${formatRupiah(subtotal)}</b>
            </div>

            ${
              note
                ? `
                  <div class="${type}-item-note">
                    Catatan: ${note}
                  </div>
                `
                : ''
            }
          </div>
        `;
      }).join('')}
    </div>
  `;
};

const openCheckoutSuccessModal = order => {
  if (!checkoutSuccessModal || !checkoutSuccessBackdrop) {
    return;
  }

  lastSavedOrder = order || null;

  const totalItem = Number(order?.total_item || 0);
  const totalPrice = Number(order?.total_price || 0);
  const orderItems = Array.isArray(order?.items) ? order.items : [];

  if (successOrderCode) {
    successOrderCode.textContent = order?.order_code || '-';
  }

  if (successOrderItems) {
    successOrderItems.innerHTML = renderModalOrderItems(orderItems, 'success');
  }

  if (successTotalItem) {
    successTotalItem.textContent = `${totalItem} item`;
  }

  if (successTotalPrice) {
    successTotalPrice.textContent = formatRupiah(totalPrice);
  }

  checkoutSuccessModal.classList.add('show');
  checkoutSuccessBackdrop.classList.add('show');
};

const openCheckoutConfirmModal = () => {
  if (!cart.length) {
    showToast('Cart masih kosong.');
    return;
  }

  closeCartDrawer();

  if (confirmOrderItems) {
    confirmOrderItems.innerHTML = renderModalOrderItems(cart, 'confirm');
  }

  if (confirmTotalItem) {
    confirmTotalItem.textContent = `${cartTotalQuantity()} item`;
  }

  if (confirmTotalPrice) {
    confirmTotalPrice.textContent = formatRupiah(cartTotalPrice());
  }

  setTimeout(() => {
    checkoutConfirmModal?.classList.add('show');
    checkoutConfirmBackdrop?.classList.add('show');
  }, 180);
};

cancelCheckout?.addEventListener('click', closeCheckoutConfirmModal);
checkoutConfirmBackdrop?.addEventListener('click', closeCheckoutConfirmModal);

successStayPos?.addEventListener('click', () => {
  closeCheckoutSuccessModal();
});

successGoHistory?.addEventListener('click', () => {
  window.location.href = window.NGUNJUK_ROUTES.history;
});

checkoutSuccessBackdrop?.addEventListener('click', closeCheckoutSuccessModal);

document.addEventListener('keydown', event => {
  if (event.key === 'Escape') {
    closeCheckoutSuccessModal();
    closeCheckoutConfirmModal();
    closeCartDrawer();
  }
});

openCart?.addEventListener('click', openCartDrawer);
closeCart?.addEventListener('click', closeCartDrawer);
cartBackdrop?.addEventListener('click', closeCartDrawer);

const getProductImage = product => {
  const fallbackImage =
    'https://images.unsplash.com/photo-1517701604599-bb29b565090c?auto=format&fit=crop&w=500&q=80';

  if (!product.image) {
    return fallbackImage;
  }

  if (product.image.startsWith('http://') || product.image.startsWith('https://')) {
    return product.image;
  }

  const imagePath = product.image
    .replace(/^\/storage\//, '')
    .replace(/^storage\//, '')
    .replace(/^\/+/, '');

  return `${window.NGUNJUK_ROUTES.storage}/${imagePath}`;
};

const normalizeProduct = product => {
  const sizes = Array.isArray(product.sizes) ? product.sizes : [];

  return {
    id: Number(product.id),
    category_id: Number(product.category_id),
    category: product.category?.name || 'Menu',
    name: product.name || '-',
    description: product.description || '-',
    image: getProductImage(product),
    sizes: sizes.map(size => ({
      id: Number(size.id),
      name: size.name,
      price: Number(size.price || 0),
      is_default: Boolean(size.is_default),
      is_active: Boolean(size.is_active ?? true)
    }))
  };
};

const getDefaultSize = product => {
  if (!product.sizes || product.sizes.length === 0) {
    return null;
  }

  return product.sizes.find(size => size.is_default) || product.sizes[0];
};

const getSelectedSize = productId => {
  const selected = document.querySelector(
    `button.size-btn.active[data-product-id="${productId}"]`
  );

  if (!selected) {
    const product = products.find(item => item.id === Number(productId));
    return product ? getDefaultSize(product) : null;
  }

  return {
    id: Number(selected.dataset.sizeId),
    name: selected.dataset.sizeName,
    price: Number(selected.dataset.price)
  };
};

const cartTotalQuantity = () => {
  return cart.reduce((total, item) => total + Number(item.quantity || 0), 0);
};

const cartTotalPrice = () => {
  return cart.reduce((total, item) => {
    return total + Number(item.price || 0) * Number(item.quantity || 0);
  }, 0);
};

const setDefaultActiveCategory = () => {
  activeCategory =
    categories.find(category => category.toLowerCase() === 'teh') ||
    categories.find(category => category.toLowerCase().includes('teh')) ||
    categories[0] ||
    '';
};

const loadProducts = async () => {
  try {
    const response = await fetch(window.NGUNJUK_ROUTES.products, {
      method: 'GET',
      headers: {
        Accept: 'application/json'
      }
    });

    const result = await response.json();

    if (!response.ok || !result.success) {
      throw new Error(result.message || 'Gagal mengambil produk.');
    }

    products = result.data.map(normalizeProduct);
    categories = [...new Set(products.map(product => product.category))];

    setDefaultActiveCategory();
    renderCategories();
    renderProducts();
  } catch (error) {
    console.error(error);
    showToast('Gagal mengambil data produk.');
  }
};

const renderCategories = () => {
  if (!categoryTabs) {
    return;
  }

  categoryTabs.innerHTML = '';

  categories.forEach(category => {
    const button = document.createElement('button');
    button.type = 'button';
    button.className = category === activeCategory ? 'active' : '';
    button.textContent = category;

    button.addEventListener('click', () => {
      activeCategory = category;

      if (searchInput) {
        searchInput.value = '';
      }

      renderCategories();
      renderProducts();
    });

    categoryTabs.appendChild(button);
  });
};

const renderProducts = () => {
  if (!productGrid) {
    return;
  }

  const keyword = searchInput?.value.toLowerCase().trim() || '';
  const isSearching = keyword.length > 0;

  const filteredProducts = products.filter(product => {
    const productName = String(product.name || '').toLowerCase();
    const productDescription = String(product.description || '').toLowerCase();
    const productCategory = String(product.category || '').toLowerCase();

    const matchSearch =
      productName.includes(keyword) ||
      productDescription.includes(keyword) ||
      productCategory.includes(keyword);

    if (isSearching) {
      return matchSearch;
    }

    return product.category === activeCategory;
  });

  if (menuTitle) {
    menuTitle.textContent = isSearching
      ? `Hasil pencarian "${keyword}"`
      : `${activeCategory || 'Menu'} menu`;
  }

  productGrid.innerHTML = '';

  if (!filteredProducts.length) {
    productGrid.innerHTML = `
      <div class="cart-empty product-empty">
        Produk tidak ditemukan.
      </div>
    `;
    return;
  }

  filteredProducts.forEach(product => {
    const defaultSize = getDefaultSize(product);
    const displayPrice = defaultSize ? defaultSize.price : 0;

    const card = document.createElement('article');
    card.className = 'product-card';

    const sizeHtml = product.sizes.length > 1
      ? `
        <div class="size-row">
          <span class="size-label">Size</span>

          ${product.sizes.map(size => `
            <button
              type="button"
              class="size-btn ${defaultSize && size.id === defaultSize.id ? 'active' : ''}"
              data-product-id="${product.id}"
              data-size-id="${size.id}"
              data-size-name="${escapeHTML(size.name)}"
              data-price="${size.price}"
            >
              ${escapeHTML(size.name)}
            </button>
          `).join('')}
        </div>
      `
      : `
        <div class="size-row">
          <span class="size-label">Size</span>
          <span class="regular-size">
            ${defaultSize ? escapeHTML(defaultSize.name) : 'Regular'} / satu ukuran
          </span>
        </div>
      `;

    card.innerHTML = `
      <div class="drink-img">
        <img src="${escapeHTML(product.image)}" alt="${escapeHTML(product.name)}">
      </div>

      <div class="product-info">
        <div class="product-head">
          <div>
            <h3>${escapeHTML(product.name)}</h3>
          </div>

          <strong class="price">${formatRupiah(displayPrice)}</strong>
        </div>

        ${sizeHtml}

        <div class="card-footer">
          <div class="qty-row">
            <button
              type="button"
              class="qty-btn qty-minus"
              data-id="${product.id}"
            >
              −
            </button>

            <span id="qty-${product.id}">1</span>

            <button
              type="button"
              class="qty-btn qty-plus"
              data-id="${product.id}"
            >
              +
            </button>
          </div>

          <button
            type="button"
            class="add-btn add-cart-btn"
            data-id="${product.id}"
            ${!defaultSize ? 'disabled' : ''}
          >
            Add to Cart
          </button>
        </div>
      </div>
    `;

    productGrid.appendChild(card);
  });
};

const getQuantity = productId => {
  const quantityElement = document.querySelector(`#qty-${productId}`);

  return Number(quantityElement?.textContent || 1);
};

const setQuantity = (productId, quantity) => {
  const quantityElement = document.querySelector(`#qty-${productId}`);

  if (!quantityElement) {
    return;
  }

  quantityElement.textContent = Math.max(1, quantity);
};

const addToCart = item => {
  const existingItem = cart.find(cartItem => {
    return cartItem.product_id === item.product_id &&
      cartItem.product_size_id === item.product_size_id;
  });

  if (existingItem) {
    existingItem.quantity += item.quantity;
    return;
  }

  cart.push(item);
};

productGrid?.addEventListener('click', event => {
  const sizeButton = event.target.closest('.size-btn');
  const minusButton = event.target.closest('.qty-minus');
  const plusButton = event.target.closest('.qty-plus');
  const addButton = event.target.closest('.add-cart-btn');

  if (sizeButton) {
    const productId = Number(sizeButton.dataset.productId);

    document
      .querySelectorAll(`.size-btn[data-product-id="${productId}"]`)
      .forEach(button => button.classList.remove('active'));

    sizeButton.classList.add('active');

    const productCard = sizeButton.closest('.product-card');
    const priceElement = productCard?.querySelector('.price');

    if (priceElement) {
      priceElement.textContent = formatRupiah(Number(sizeButton.dataset.price || 0));
    }

    return;
  }

  if (minusButton) {
    const productId = Number(minusButton.dataset.id);
    const currentQuantity = getQuantity(productId);

    setQuantity(productId, currentQuantity - 1);
    return;
  }

  if (plusButton) {
    const productId = Number(plusButton.dataset.id);
    const currentQuantity = getQuantity(productId);

    setQuantity(productId, currentQuantity + 1);
    return;
  }

  if (addButton) {
    const productId = Number(addButton.dataset.id);
    const product = products.find(item => item.id === productId);

    if (!product) {
      showToast('Produk tidak ditemukan.');
      return;
    }

    const selectedSize = product.sizes.length > 1
      ? getSelectedSize(product.id)
      : getDefaultSize(product);

    if (!selectedSize) {
      showToast('Size produk belum tersedia.');
      return;
    }

    const quantity = getQuantity(product.id);

    addToCart({
      product_id: product.id,
      product_size_id: selectedSize.id,
      name: product.name,
      image: product.image,
      size: selectedSize.name,
      price: selectedSize.price,
      quantity,
      note: ''
    });

    addButton.textContent = 'Added to cart';
    addButton.classList.add('added');

    setTimeout(() => {
      addButton.textContent = 'Add to Cart';
      addButton.classList.remove('added');
    }, 1200);

    showToast('Produk berhasil ditambahkan ke cart.');
    renderCart();
  }
});

const renderCart = () => {
  if (!cartList) {
    return;
  }

  cartList.innerHTML = '';

  if (!cart.length) {
    cartList.innerHTML = `
      <div class="cart-empty">
        Keranjang masih kosong.
      </div>
    `;
  }

  cart.forEach(item => {
    const cartItem = document.createElement('div');
    cartItem.className = 'cart-item';

    cartItem.innerHTML = `
      <div class="cart-img">
        <img src="${escapeHTML(item.image)}" alt="${escapeHTML(item.name)}">
      </div>

      <div class="cart-item-info">
        <div class="cart-item-top">
          <div>
            <h3>${escapeHTML(item.name)}</h3>
            <p class="cart-item-meta">${escapeHTML(item.size)}</p>
          </div>

          <strong class="cart-line-total">
            ${formatRupiah(item.price * item.quantity)}
          </strong>
        </div>

        <div class="cart-price-row">
          <strong>${formatRupiah(item.price)}</strong>

          <div class="qty-row">
            <button
              type="button"
              class="qty-btn cart-minus"
              data-id="${item.product_id}"
              data-size-id="${item.product_size_id}"
            >
              −
            </button>

            <span>${item.quantity}</span>

            <button
              type="button"
              class="qty-btn cart-plus"
              data-id="${item.product_id}"
              data-size-id="${item.product_size_id}"
            >
              +
            </button>
          </div>
        </div>

        <label class="cart-note-wrap">
          <span>Catatan pesanan</span>
          <input
            type="text"
            class="cart-note-input"
            data-id="${item.product_id}"
            data-size-id="${item.product_size_id}"
            value="${escapeHTML(item.note || '')}"
            placeholder="Contoh: less ice, less sugar..."
            maxlength="120"
          >
        </label>
      </div>
    `;

    cartList.appendChild(cartItem);
  });

  if (cartCount) {
    cartCount.textContent = cartTotalQuantity();
  }

  if (itemsTotal?.previousElementSibling) {
    itemsTotal.previousElementSibling.textContent = 'Total Item';
  }

  if (grandTotal?.previousElementSibling) {
    grandTotal.previousElementSibling.textContent = 'Total Harga';
  }

  if (itemsTotal) {
    itemsTotal.textContent = `${cartTotalQuantity()} item`;
  }

  if (grandTotal) {
    grandTotal.textContent = formatRupiah(cartTotalPrice());
  }
};

cartList?.addEventListener('input', event => {
  const noteInput = event.target.closest('.cart-note-input');

  if (!noteInput) {
    return;
  }

  const productId = Number(noteInput.dataset.id);
  const productSizeId = Number(noteInput.dataset.sizeId);

  const item = cart.find(cartItem => {
    return cartItem.product_id === productId &&
      cartItem.product_size_id === productSizeId;
  });

  if (!item) {
    return;
  }

  item.note = noteInput.value;
});

cartList?.addEventListener('click', event => {
  const minusButton = event.target.closest('.cart-minus');
  const plusButton = event.target.closest('.cart-plus');

  if (!minusButton && !plusButton) {
    return;
  }

  const button = minusButton || plusButton;
  const productId = Number(button.dataset.id);
  const productSizeId = Number(button.dataset.sizeId);

  const item = cart.find(cartItem => {
    return cartItem.product_id === productId &&
      cartItem.product_size_id === productSizeId;
  });

  if (!item) {
    return;
  }

  if (minusButton) {
    item.quantity -= 1;

    if (item.quantity <= 0) {
      cart = cart.filter(cartItem => {
        return !(cartItem.product_id === productId &&
          cartItem.product_size_id === productSizeId);
      });
    }
  }

  if (plusButton) {
    item.quantity += 1;
  }

  renderCart();
});

const buildCheckoutReceiptHtml = order => {
  const totalItem = Number(order?.total_item || 0);
  const totalPrice = Number(order?.total_price || 0);
  const orderedAt = order?.ordered_at || order?.ordered_at_human || new Date().toISOString();
  const items = Array.isArray(order?.items) ? order.items : [];

  const itemRows = items.map(item => {
    const productName = item.product_name || item.name || '-';
    const sizeName = item.size_name || item.size || 'Regular';
    const quantity = Number(item.quantity || 0);
    const price = Number(item.price || item.unit_price || 0);
    const subtotal = Number(item.subtotal || price * quantity || 0);
    const note = item.note
      ? `<div class="note">Catatan: ${escapeHTML(item.note)}</div>`
      : '';

    return `
      <div class="item">
        <div class="item-title">
          <strong>${escapeHTML(productName)}</strong>
        </div>

        <div class="item-meta">
          <span>${escapeHTML(sizeName)} x${quantity}</span>
          <span>${formatRupiah(price)}</span>
        </div>

        ${note}

        <div class="item-subtotal">
          <span>Subtotal</span>
          <strong>${formatRupiah(subtotal)}</strong>
        </div>
      </div>
    `;
  }).join('');

  return `
    <!DOCTYPE html>
    <html lang="id">
    <head>
      <meta charset="UTF-8">
      <title>Struk ${escapeHTML(order?.order_code || '-')}</title>
      <style>
        * {
          box-sizing: border-box;
        }

        body {
          margin: 0;
          padding: 18px;
          font-family: Arial, sans-serif;
          color: #1f1f1f;
          background: #ffffff;
        }

        .receipt {
          width: 300px;
          margin: 0 auto;
        }

        .center {
          text-align: center;
        }

        .brand {
          margin-bottom: 4px;
          font-size: 21px;
          font-weight: 800;
          letter-spacing: 1px;
        }

        .brand span {
          color: #e8733d;
        }

        .subtitle {
          font-size: 11px;
          line-height: 1.4;
          color: #666666;
        }

        .line {
          border-top: 1px dashed #999999;
          margin: 12px 0;
        }

        .info,
        .total {
          display: grid;
          gap: 6px;
          font-size: 12px;
        }

        .info div,
        .total div,
        .item-meta,
        .item-subtotal {
          display: flex;
          justify-content: space-between;
          gap: 10px;
        }

        .info span,
        .total span {
          color: #555555;
        }

        .item {
          padding-bottom: 10px;
          margin-bottom: 10px;
          border-bottom: 1px dashed #dddddd;
          font-size: 12px;
        }

        .item:last-child {
          border-bottom: 0;
          margin-bottom: 0;
          padding-bottom: 0;
        }

        .item-title strong {
          display: block;
          font-size: 13px;
          line-height: 1.35;
        }

        .item-meta {
          margin-top: 4px;
          color: #666666;
        }

        .note {
          margin-top: 6px;
          padding: 6px 7px;
          border-radius: 6px;
          background: #f4f4f4;
          color: #444444;
          font-size: 11px;
          line-height: 1.35;
        }

        .item-subtotal {
          margin-top: 6px;
          font-size: 12px;
        }

        .grand {
          padding-top: 7px;
          border-top: 1px dashed #999999;
          font-size: 15px;
          font-weight: 800;
        }

        .thanks {
          margin-top: 14px;
          font-size: 12px;
          line-height: 1.5;
          text-align: center;
        }

        .small {
          margin-top: 4px;
          color: #666666;
          font-size: 10px;
          text-align: center;
        }

        @media print {
          @page {
            size: 80mm auto;
            margin: 4mm;
          }

          body {
            padding: 0;
          }

          .receipt {
            width: 100%;
          }
        }
      </style>
    </head>

    <body>
      <div class="receipt">
        <div class="center">
          <div class="brand"><span>Ngun</span>juk POS</div>
          <div class="subtitle">
            Sistem Informasi Kasir<br>
            UMKM Ngunjuk
          </div>
        </div>

        <div class="line"></div>

        <div class="info">
          <div>
            <span>Order</span>
            <strong>${escapeHTML(order?.order_code || '-')}</strong>
          </div>

          <div>
            <span>Waktu</span>
            <strong>${formatReceiptDateTime(orderedAt)}</strong>
          </div>

          <div>
            <span>Status</span>
            <strong>${escapeHTML(order?.status || 'Selesai')}</strong>
          </div>
        </div>

        <div class="line"></div>

        ${itemRows || '<div class="item">Item tidak tersedia.</div>'}

        <div class="line"></div>

        <div class="total">
          <div>
            <span>Total Item</span>
            <strong>${totalItem} item</strong>
          </div>

          <div class="grand">
            <span>Total</span>
            <strong>${formatRupiah(totalPrice)}</strong>
          </div>
        </div>

        <div class="line"></div>

        <div class="thanks">
          Terima kasih sudah berbelanja.
        </div>

        <div class="small">
          Struk ini dicetak otomatis oleh Ngunjuk POS.
        </div>
      </div>

      <script>
        window.onload = function () {
          window.print();

          setTimeout(function () {
            window.close();
          }, 500);
        };
      <\/script>
    </body>
    </html>
  `;
};

const printLastSavedOrder = () => {
  if (!lastSavedOrder) {
    showToast('Data order belum tersedia.');
    return;
  }

  const printWindow = window.open('', '_blank', 'width=420,height=680');

  if (!printWindow) {
    showToast('Popup print diblokir browser.');
    return;
  }

  printWindow.document.open();
  printWindow.document.write(buildCheckoutReceiptHtml(lastSavedOrder));
  printWindow.document.close();
};

successPrintReceipt?.addEventListener('click', printLastSavedOrder);

const submitOrder = async () => {
  if (!cart.length) {
    showToast('Cart masih kosong.');
    return;
  }

  const payload = {
    items: cart.map(item => ({
      product_id: item.product_id,
      product_size_id: item.product_size_id,
      quantity: item.quantity,
      note: item.note || null
    }))
  };

  if (placeOrder) {
    placeOrder.disabled = true;
    placeOrder.textContent = 'Memproses...';
  }

  try {
    const response = await fetch(window.NGUNJUK_ROUTES.orders, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
        'X-CSRF-TOKEN': window.NGUNJUK_CSRF_TOKEN
      },
      body: JSON.stringify(payload)
    });

    const result = await response.json();

    if (!response.ok || !result.success) {
      throw new Error(result.message || 'Gagal menyimpan transaksi.');
    }

    const savedOrder = result.data || {};

    cart = [];
    renderCart();
    closeCartDrawer();

    showToast('Transaksi berhasil masuk ke database.');
    openCheckoutSuccessModal(savedOrder);

    await loadProducts();
  } catch (error) {
    console.error(error);
    showToast(error.message || 'Gagal menyimpan transaksi.');
  } finally {
    if (placeOrder) {
      placeOrder.disabled = false;
      placeOrder.textContent = 'Place an order';
    }
  }
};

placeOrder?.addEventListener('click', openCheckoutConfirmModal);

confirmCheckout?.addEventListener('click', () => {
  closeCheckoutConfirmModal();
  submitOrder();
});

searchInput?.addEventListener('input', () => {
  renderProducts();
});

renderCart();
loadProducts();
