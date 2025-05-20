        </div>
    </main>
    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> MVC Views. All rights reserved.</p>
        </div>
    </footer>
</body>

    <script>
        $(document).ready(function() {
            if ($("#messageModal").length) {
                $("#messageModal").modal("show");
            }
        });
    </script>

</html>