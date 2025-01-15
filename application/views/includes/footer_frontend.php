            <!-- footer -->
            <div class="container-fluid">
                <div class="row">
                    <div class="footer">
                        <p id="text-dark">Copyright &copy; <script>
                                document.write(new Date().getFullYear())

                            </script> - Conçu et développé par <a class="text-dark font-weight-bold text-decoration-none" href="mediabox.bi">Mediabox SA Burundi <img alt="Mediabox Logo" width="30px" src="<?=base_url()?>assets/frontend/images/mediabox_logo.png"></a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- end dashboard inner -->
    </div>


  <script src="<?=base_url()?>assets/frontend/js/jquery-3.6.0.js"></script>


    <script src="<?=base_url()?>assets/frontend/js/bootstrap.min.js"></script>

  
    <!-- wow animation -->
    <script src="<?=base_url()?>assets/frontend/js/animate.js"></script>
    <!-- select country -->
    <script src="<?=base_url()?>assets/frontend/js/bootstrap-select.js"></script>
    <script src="<?=base_url()?>assets/frontend/js/bootstrap-datetimepicker.js"></script>
    <script src="<?=base_url()?>assets/frontend/js/moment.js"></script>
    <script src="<?=base_url()?>assets/frontend/js/daterangepicker.js"></script>
    <script src="<?=base_url()?>assets/frontend/js/selectize.js"></script>

    <!-- Datatables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $('#daterangepicker').daterangepicker({
            timePicker: true,
            startDate: new Date(),
            endDate: "+1m"
        })

    </script>

    <script>
        $('#datetimepicker').datetimepicker({
            datepicker: true,
            timepicker: true,
            startDate: "+2d",
            endDate: "+1m"
        });

    </script>


    <!-- Selectize dropdown -->
    <script>
        $(function() {
            $(".selectize").selectize({
                highlight: true,
                sortField: "text",
            });
        });

    </script>