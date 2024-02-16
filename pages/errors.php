<?php global $errors;
if (count($errors) > 0) : ?>
    <?php for ($i = 0; $i < count($errors); $i++) : ?>
        <section class="notification is-danger toast">
            <button class="delete" id="<?php echo 'toast_' . $i ?>"></button>
            <p><?php echo $errors[$i] ?></p>
        </section>
    <?php endfor; ?>
    <style>
        .toast {
            position: absolute;
            z-index: 1200;
            right: 0;
            bottom: 1rem;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach((toast, index) => {
                toast.querySelector('.delete').addEventListener('click', () => {
                    toast.remove();
                });
            });
        });
    </script>
<?php endif; ?>