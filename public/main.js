document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', () => {
      const btn = form.querySelector('button[type="submit"],button:not([type])');
      if (btn && !form.dataset.noLoading) {
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span>Đang xử lý...';
      }
    });
  });

  // Server-Sent Events: live pending-order count in the admin dashboard.
  const liveOrders = document.querySelector('[data-admin-events]');
  if (liveOrders && 'EventSource' in window) {
    const countNode = liveOrders.querySelector('[data-pending-count]');
    const source = new EventSource('admin_events.php');
    source.addEventListener('pending-orders', event => {
      try {
        const payload = JSON.parse(event.data);
        if (countNode) countNode.textContent = String(payload.count ?? 0);
        liveOrders.classList.toggle('has-pending', Number(payload.count) > 0);
      } catch (_) { /* Ignore malformed event payloads. */ }
    });
    source.onerror = () => { /* EventSource reconnects automatically. */ };
  }
});
