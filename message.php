<div
    class="modal fade"
    id="messageModal"
    tabindex="-1"
    aria-labelledby="messageModalLabel"
    aria-hidden="true"
    role="dialog"
    aria-modal="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Тело модального окна: вывод сообщений -->
            <div class="modal-body">
                <?php
                // Вывод сообщения из сессии (если есть)
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    // Очищаем сообщение в сессии после показа, чтобы избежать дублирования
                    $_SESSION['msg'] = '';
                }

                // Вывод локального сообщения (если установлено)
                if (isset($msg)) {
                    echo $msg;
                }
                ?>
            </div>

            <!-- Подвал модального окна с кнопкой закрытия -->
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Закрыть
                </button>
            </div>
        </div>
    </div>
</div>
