<div class="<?php echo implode( " ", $classes ); ?>" data-humbleflarecount="<?php echo $humbleflarecount; ?>">
    <span class="loading"><span></span></span>
    <span class="<?php echo "{$namespace}-total"; ?> first"><strong><?php echo flare_formatted_count( $total_count ); ?></strong> Flares</span>
    
    <?php $counter = 0; foreach( $buttons as $button ): ?>
        <?php
            $button_classes = array(
                "{$namespace}-button",
                "button-type-{$button['type']}",
                "{$namespace}-iconstyle-{$iconstyle}"
            );
            if( $counter == 0 ) $button_classes[] = "first";
            if( $button == end( $buttons ) ) $button_classes[] = "last";
        ?>
        <span data-type="<?php echo $button['type']; ?>" class="<?php echo implode( " ", $button_classes ); ?>" style="background-color:<?php echo $button['color']; ?>;z-index:<?php echo count( $buttons ) - $counter; ?>">
            <span class="<?php echo $namespace; ?>-button-wrap">
                <span class="<?php echo $namespace; ?>-button-icon"><?php echo $available_buttons[$button['type']]['label']; ?></span>
            </span>
        </span>
        <span class="<?php echo $namespace; ?>-button-count"><?php echo isset( $counts[$button['type']] ) ? flare_formatted_count( $counts[$button['type']] ) : 0; ?></span>
            
        <span class="<?php echo $namespace; ?>-flyout <?php echo $namespace; ?>-flyout-<?php echo $button['type']; ?><?php if( $counter == 0 ) echo ' first'; $counter++; ?>">
            <span class="<?php echo $namespace; ?>-flyout-inner">
                <span class="<?php echo $namespace; ?>-arrow"></span>
            </span>
            <span class="<?php echo $namespace; ?>-iframe-wrapper">
                <?php flare_code_snippet( $button['type'], $direction ); ?>
            </span>
        </span>
        
    <?php endforeach; ?>

    <span class="<?php echo "{$namespace}-total"; ?> last"><strong><?php echo flare_formatted_count( $total_count ); ?></strong> Flares</span>

    <span class="close">
        <a href="#close">&#215;</a>
    </span>
</div>