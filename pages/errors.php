<?php if (count($errors) > 0) : ?>
    <section class="error">
        <?php foreach ($errors as $error) : ?>
            <p><?php echo $error ?></p>
        <?php endforeach ?>
    </section>
<?php endif ?>