<?php $sistema = \DB::table('configuracion')->where('id', 1)->first(); ?>
   <footer class="footer">
        <div class="text-center">{{'2018 - '}}<?php echo $sistema->nombre_empresa; ?> - {{'Creado: Oswaldo Gerardino'}}</div>
   </footer>

    </div> <!-- end container -->
</div>
<!-- end wrapper -->


