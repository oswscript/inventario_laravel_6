<?php $sistema = \DB::table('configuracion')->where('id', 1)->first(); ?>
   <footer class="footer text-right">
        {{"2020"}} - <?php echo $sistema->nombre_empresa; ?> - Version 1.2.0 - <a target="_blank" href="https://oswscript.com">oswscript.com</a>
   </footer>

</div>