<div class="row sidebar-footer">
    <ul class="block-grid four-up mobile">
        <?php
        if (is_front_page()) {
            dynamic_sidebar("Footer Front Page Widget Area");
        } else {
            dynamic_sidebar("Footer Single Page Widget Area");
        }


        ?>
    </ul>
</div>
