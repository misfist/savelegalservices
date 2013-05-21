<footer id="main-footer" class="main-footer">
    <?php

    if (!is_404())
        get_sidebar('footer'); //Add footer sidebar
    ?>
    <div id="footer-bottom">
        <div class="row">
            <div class="four columns">


                Powered by <a href="http://netbiel.pl/smartadapt" title="smartadapt">SmartAdapt</a>.
            </div>
            <div class="twelve columns footer-navigation">
                <?php wp_nav_menu(array('theme_location' => 'footer_pages', 'container' => false)); ?>
            </div>
        </div>
    </div>
</footer>
    <?php wp_footer(); ?>
</body>
</html>
