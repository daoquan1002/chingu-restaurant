    </main>
  </div>

  <!-- Bootstrap 5 JS CDN -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // Toggle sidebar trên thiết bị di động
    const btnToggleSidebar = document.getElementById('btnToggleSidebar');
    const adminSidebar = document.getElementById('adminSidebar');
    if (btnToggleSidebar && adminSidebar) {
      btnToggleSidebar.addEventListener('click', () => {
        adminSidebar.classList.toggle('show');
      });
    }
  </script>
</body>
</html>
