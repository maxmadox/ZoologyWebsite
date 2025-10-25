    <footer class="transparent-footer">
        <p>&copy; 2025 Zoology Department, Kirodimal Govt. Arts & Science College, Raigarh</p>
    </footer>

</body>
</html>

<script>
const hamburger = document.querySelector('.hamburger');
const mobileMenu = document.querySelector('.mobile-nav');

if (hamburger && mobileMenu) {
    hamburger.addEventListener('click', () => {
        mobileMenu.classList.toggle('active');
    });
}
</script>
