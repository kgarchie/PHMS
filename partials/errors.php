<?php global $errors;

if (count($errors) > 0) : ?>
    <?php for ($i = 0; $i < count($errors); $i++) : ?>
        <section class="is-danger custom-toast shadow" <?php echo 'style="margin-bottom: ' . $i * 2.5 . 'rem;"' ?> id="<?php echo 'toast_' . $i ?>">
            <button class="delete" id="<?php echo 'toast_' . $i ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="icon">
                    <path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 15H13V17H11V15ZM11 7H13V13H11V7Z"></path>
                </svg>
            </button>
            <p class="d-flex m-0"><?php echo $errors[$i] ?></p>
        </section>
    <?php endfor; ?>
    <style>
        .delete {
            background-color: transparent;
            border: none;
            cursor: pointer;
            right: 1rem;
            top: 1rem;
        }

        .custom-toast {
            position: absolute;
            z-index: 1200;
            right: 1rem;
            bottom: 1rem;
            transition: opacity 1s;
            color: white;
            padding: 1rem;
            border-radius: 5px;
            display: flex;
            height: 20px;
            max-width: 80vw;
            align-items: center;
        }

        .is-danger{
            background-color: #f14668;
        }

        .icon {
            width: 1.5rem;
            height: 1.5rem;

            fill: white;
            margin-right: 0.25rem;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toasts = document.querySelectorAll('.custom-toast');
            toasts.forEach(toast => {
                toast.querySelector('.delete').addEventListener('click', () => {
                    toast.remove();
                });
                const animateInterval = setInterval(() => {
                    let opacity = parseFloat(toast.style.opacity || 1);
                    opacity -= 0.1;
                    toast.style.opacity = `${opacity}`;
                }, 500);
                setTimeout(() => {
                    clearInterval(animateInterval);
                    toast.remove();
                }, 5000);
            });
        });
    </script>
<?php endif; ?>
