        </div>
    </main>
    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> CitrusApp. All rights reserved.</p>
        </div>
    </footer>
    <script>
        // Simple JavaScript for mobile menu toggle
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('navLinks').classList.toggle('active');
        });
    </script>
</body>
</html>