document.addEventListener('DOMContentLoaded', function() {
    function calculateReadingTime() {
        const articleBody = document.querySelector('.article-body');
        const timeElement = document.getElementById('reading-time');

        if (!articleBody || !timeElement) return;

        const text = articleBody.textContent || articleBody.innerText;
        const words = text.trim().split(/\s+/).filter(word => word.length > 0);
        const wordCount = words.length;
        const readingTime = Math.max(1, Math.ceil(wordCount / 200));

        timeElement.innerHTML = `<i class="fi-rr-time"></i> Время чтения: ~${readingTime} мин`;
    }

    calculateReadingTime();
});