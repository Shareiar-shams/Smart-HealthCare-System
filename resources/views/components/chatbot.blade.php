<div id="chatbot-container">
    <iframe 
        src="{{ asset('chatbot/index.html') }}" 
        id="chatbot-frame" 
        frameborder="0">
    </iframe>
</div>

<style>
#chatbot-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 400px;
    height: 500px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    z-index: 9999;
    display: none;
}

#chatbot-frame {
    width: 100%;
    height: 100%;
    border: none;
}

#chatbot-toggle {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    font-size: 24px;
    cursor: pointer;
    box-shadow: 0 3px 6px rgba(0,0,0,0.3);
    z-index: 10000;
}
</style>

<button id="chatbot-toggle">💬</button>

<script>
(function() {
    const toggleBtn = document.getElementById('chatbot-toggle');
    const container = document.getElementById('chatbot-container');
    const iframe = document.getElementById('chatbot-frame');

    function openInsideIframe() {
        try {
            const doc = iframe.contentDocument || iframe.contentWindow.document;
            if (!doc) return;
            // Add the class that the chatbot uses to show the popup
            doc.body.classList.add('show-chatbot');
            // Focus message input if available
            const input = doc.querySelector('.message-input');
            if (input) input.focus();
        } catch (e) {
            // Fallback: ask iframe to handle it if it listens to postMessage
            if (iframe.contentWindow && iframe.contentWindow.postMessage) {
                iframe.contentWindow.postMessage({ type: 'OPEN_CHATBOT' }, '*');
            }
        }
    }

    function closeInsideIframe() {
        try {
            const doc = iframe.contentDocument || iframe.contentWindow.document;
            if (doc) doc.body.classList.remove('show-chatbot');
        } catch (e) { /* ignore */ }
    }

    toggleBtn.addEventListener('click', function() {
        const isHidden = (container.style.display === 'none' || container.style.display === '');
        container.style.display = isHidden ? 'block' : 'none';

        if (isHidden) {
            // Ensure iframe is loaded before manipulating its DOM
            const ready = () => {
                iframe.dataset.loaded = '1';
                openInsideIframe();
            };

            if (iframe.dataset.loaded === '1') {
                openInsideIframe();
            } else if (iframe.contentDocument && iframe.contentDocument.readyState === 'complete') {
                ready();
            } else {
                iframe.addEventListener('load', function onLoad() {
                    iframe.removeEventListener('load', onLoad);
                    ready();
                });
            }
        } else {
            // Closing: also close popup inside iframe
            closeInsideIframe();
        }
    });
})();
</script>