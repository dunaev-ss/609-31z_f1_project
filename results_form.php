<div class="card border-dark mb-3">
    <div class="card-header">Добавить запись в таблицу</div>
    <div class="card-body text-dark">
        <!-- Форма для добавления новой записи в базу данных -->
        <form method="post" action="results_ins.php">
            <!-- Первая строка формы: дата гонки, Гран‑при, пилот -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Дата гонки:</label>
                    <input
                        type="date"
                        name="event_date"
                        class="form-control"
                        required
                    >
                </div>

                <div class="col-md-4">
                    <label class="form-label">Гран‑при:</label>
                    <select
                        name="id_grand_prix"
                        class="form-select"
                        required
                    >
                        <?php
                        // Получаем список Гран‑при из базы данных
                        // Сортируем по названию (GRAND_PRIX)
                        $result = $conn->query("SELECT ID, GRAND_PRIX FROM t_grand_prix ORDER BY GRAND_PRIX");
                        while ($row = $result->fetch()) {
                            echo '<option value="' . $row['ID'] . '">' . $row['GRAND_PRIX'] . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Пилот:</label>
                    <select
                        name="id_driver"
                        class="form-select"
                        required
                    >
                        <?php
                        // Получаем список пилотов из базы данных
                        // Сортируем по имени (DRIVER)
                        $result = $conn->query("SELECT ID, DRIVER FROM t_drivers ORDER BY DRIVER");
                        while ($row = $result->fetch()) {
                            echo '<option value="' . $row['ID'] . '">' . $row['DRIVER'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- Вторая строка формы: позиция на старте, финишная позиция, очки -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Позиция на старте:</label>
                    <input
                        type="number"
                        name="grd"
                        min="1"
                        max="20"
                        placeholder="от 1 до 20"
                        class="form-control"
                        required
                    >
                </div>

                <div class="col-md-4">
                    <label class="form-label">Финишная позиция:</label>
                    <input
                        type="text"
                        name="pos"
                        maxlength="3"
                        placeholder="1, DNF"
                        class="form-control"
                        required
                    >
                </div>

                <div class="col-md-4">
                    <label class="form-label">Очки:</label>
                    <input
                        type="number"
                        name="pts"
                        min="0"
                        max="26"
                        step="1"
                        placeholder="от 0 до 26"
                        class="form-control"
                        required
                    >
                </div>
            </div>

            <!-- Третья строка формы: чекбоксы и кнопка отправки -->
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <div class="form-check">
                        <input
                            type="checkbox"
                            name="pp"
                            class="form-check-input"
                            id="ppCheck"
                        >
                        <label
                            class="form-check-label"
                            for="ppCheck"
                        >
                            Поул‑позиция
                        </label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-check">
                        <input
                            type="checkbox"
                            name="fl"
                            class="form-check-input"
                            id="flCheck"
                        >
                        <label
                            class="form-check-label"
                            for="flCheck"
                        >
                            Быстрый круг
                        </label>
                    </div>
                </div>

                <div class="col-md-4 text-end">
                    <button
                        type="submit"
                        class="btn btn-primary"
                        style="width: 120px"
                    >
                        Добавить
                    </button>
                </div>
            </div>
        </form>
    </div>    
</div>

<div class="card border-dark mb-3">
    <div class="card-header">Удалить запись из таблицы</div>
    <div class="card-body text-dark">
        <!-- Форма для удаления записи по ID -->
        <form method="post" action="results_del.php">
            <div class="d-flex gap-2 align-items-center">
                <div class="flex-grow-1">
                    <input
                        type="number"
                        id="deleteId"
                        name="id"
                        class="form-control"
                        placeholder="Введите ID записи для удаления"
                        min="1"
                        required
                    >
                </div>
                <button
                    type="submit"
                    class="btn btn-danger"
                    style="width: 120px"
                >
                    Удалить
                </button>
            </div>
        </form>
    </div>
</div>
