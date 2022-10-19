    <!-- Essential javascripts for application to work-->
    <script src="../../../includees/js/jquery-3.3.1.min.js"></script>
    <!-- <script src="../../../includees/js/popper.min.js"></script> -->
    <!-- <script src="../../../includees/js/bootstrap.min.js"></script> -->
    <script src="../../../includees/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="../../../includees/js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <!-- Google analytics script-->
<!--     <script type="text/javascript">
      if(document.location.hostname == 'pratikborsadiya.in') {
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-72504830-1', 'auto');
        ga('send', 'pageview');
      }
    </script> -->
  <!-- </body> -->
<!-- </html> -->

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="../../../includes/js/jquery331.slim.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <!-- Popper.JS -->
    <script src="../../../includes/js/popper.min.js" ></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script> -->
    <!-- Bootstrap JS -->
    <script src="../../../includes/bootstrap/js/bootstrap.min.js"></script>
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script> -->
<!--     <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script> -->
    <!-- <script src="../../../includes/librerias/chartjs/chart.min.js"></script> -->

    
    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
        <script >
      function validaCerrarSesion() {
          Modal('cargaPagina','¡Advertencia¡','¿Est&aacute;s seguro que deseas cerrar sesi&oacute;n?', 'danger', 'cerrarSesion()');
        }

        function cerrarSesion() {
          location.href='index.php';
        }
    </script>
    <script>
        $(function(){

  $('.validanumericos').keypress(function(e) {
    if(isNaN(this.value + String.fromCharCode(e.charCode))) 
     return false;
  })
  .on("cut copy paste",function(e){
    e.preventDefault();
  });

});

</script> <!-- Script para aceptar solo números-->

    <!-- JavaScript Alertify JS-->
<script src="../../../includes/js/alertify.min.js"></script>
<!-- <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script> -->

<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/61ef09ab9bd1f31184d91df9/1fq6rrhl1';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->

<script>
     $(document).ready( function () {
        // $(".UpperCase").on("keypress", function () {
        $(".UpperCase").on("blur", function () {
       $input=$(this);
       setTimeout(function () {
        $input.val($input.val().toUpperCase());
       },50);
      })
     })
</script> <!-- Script convierte Minusculas a Mayúsculas-->

<!-- <script type="text/javascript">
    var udateTime = function() {
    let currentDate = new Date(),
        hours = currentDate.getHours(),
        minutes = currentDate.getMinutes(), 
        seconds = currentDate.getSeconds(),
        weekDay = currentDate.getDay(), 
        day = currentDate.getDay(), 
        month = currentDate.getMonth(), 
        year = currentDate.getFullYear();
 
    const weekDays = [
        'Domingo',
        'Lunes',
        'Martes',
        'Miércoles',
        'Jueves',
        'Viernes',
        'Sabado'
    ];
 
    document.getElementById('weekDay').textContent = weekDays[weekDay];
    document.getElementById('day').textContent = day;
 
    const months = [
        'Enero',
        'Febrero',
        'Marzo',
        'Abril',
        'Mayo',
        'Junio',
        'Julio',
        'Agosto',
        'Septiembre',
        'Octubre',
        'Noviembre',
        'Diciembre'
    ];
 
    document.getElementById('month').textContent = months[month];
    document.getElementById('year').textContent = year;
 
    document.getElementById('hours').textContent = hours;
 
    if (minutes < 10) {
        minutes = "0" + minutes
    }
 
    if (seconds < 10) {
        seconds = "0" + seconds
    }
 
    document.getElementById('minutes').textContent = minutes;
    document.getElementById('seconds').textContent = seconds;
};
 
udateTime();
 
setInterval(udateTime, 1000);
</script> -->

</body>

</html>