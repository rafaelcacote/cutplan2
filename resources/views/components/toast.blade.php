<script>
// Toast global component
window.showToast = function(title, message, type = 'error') {
    // Remove toast anterior se existir
    const existingToast = document.querySelector('.custom-toast');
    if (existingToast) {
        existingToast.remove();
    }

    const toast = document.createElement('div');
    toast.className = `custom-toast ${type}`;
    const icon = type === 'error' ? '⚠️' : '✅';
    toast.innerHTML = `
        <button class="toast-close" onclick="this.parentElement.remove()">&times;</button>
        <div class="toast-header">
            <div class="toast-icon">${icon}</div>
            ${title}
        </div>
        <div class="toast-body">
            ${message}
        </div>
    `;
    document.body.appendChild(toast);
    setTimeout(() => toast.classList.add('show'), 100);
    setTimeout(() => {
        if (toast.parentElement) {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100%) scale(0.8)';
            setTimeout(() => toast.remove(), 400);
        }
    }, 5000);
};

// Toast CSS global (só adiciona uma vez)
if (!document.getElementById('global-toast-style')) {
    const style = document.createElement('style');
    style.id = 'global-toast-style';
    style.textContent = `
        .custom-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(255, 107, 107, 0.3);
            z-index: 9999;
            opacity: 0;
            transform: translateX(100%) scale(0.8);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            max-width: 350px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .custom-toast.success {
            background: linear-gradient(135deg, #51cf66, #40c057);
            box-shadow: 0 8px 32px rgba(81, 207, 102, 0.3);
        }
        .custom-toast.show {
            opacity: 1;
            transform: translateX(0) scale(1);
        }
        .custom-toast .toast-header {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 14px;
        }
        .custom-toast .toast-icon {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }
        .custom-toast .toast-body {
            font-size: 13px;
            line-height: 1.4;
            opacity: 0.95;
        }
        .custom-toast .toast-close {
            position: absolute;
            top: 8px;
            right: 10px;
            background: none;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.2s;
        }
        .custom-toast .toast-close:hover {
            opacity: 1;
        }
    `;
    document.head.appendChild(style);
}
</script>
