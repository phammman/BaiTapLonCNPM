// faq.js
document.addEventListener("DOMContentLoaded", () => {
  const faqItems = document.querySelectorAll('.faq-item');

  faqItems.forEach(item => {
    item.querySelector('.faq-question').addEventListener('click', () => {
      // đóng tất cả item khác
      faqItems.forEach(i => {
        if (i !== item) {
          i.classList.remove('active');
          i.querySelector('.faq-question span').textContent = "+";
        }
      });

      // mở/đóng item hiện tại
      item.classList.toggle('active');
      const sign = item.classList.contains('active') ? "-" : "+";
      item.querySelector('.faq-question span').textContent = sign;
    });
  });
});