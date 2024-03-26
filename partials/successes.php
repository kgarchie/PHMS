<?php global $successes;

if (count($successes) > 0) : ?>
    <?php for ($i = 0; $i < count($successes); $i++) : ?>
        <section class="is-success custom-toast shadow" <?php echo 'style="margin-bottom: ' . $i * 2.5 . 'rem;"' ?> id="<?php echo 'toast_' . $i ?>">
            <button class="delete" id="<?php echo 'toast_' . $i ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="icon">
                    <path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 15H13V17H11V15ZM11 7H13V13H11V7Z"></path>
                </svg>
            </button>
            <p class="d-flex m-0"><?php echo $successes[$i] ?></p>
        </section>
    <?php endfor; ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            snuffToasts();
        });
    </script>
<?php endif; ?>
