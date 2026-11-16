                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <!-- SB Admin Scripts -->
    <script src="assets/js/scripts.js"></script>
    <!-- Simple-DataTables CDN -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script>
        window.addEventListener('DOMContentLoaded', event => {
            const datatablesSimple = document.getElementById('datatablesSimple');
            if (datatablesSimple) {
                window.adminDataTable = new simpleDatatables.DataTable(datatablesSimple, {
                    labels: {
                        placeholder: "Tìm kiếm nhanh...",
                        perPage: "bản ghi / trang",
                        noRows: "Không có dữ liệu trong bảng",
                        info: "Hiển thị từ {start} đến {end} trên tổng số {rows} bản ghi",
                    }
                });
            }
        });
    </script>
</body>
</html>
