<?php
foreach ($alertas as $key => $mensajes):
    foreach ($mensajes as $mensaje): ?>
    <div class="ui inverted red segment <?php echo $key; ?>">
        <?php echo "<p>" . $mensaje . "</p>"; ?>
    </div>
<?php endforeach;
endforeach;
