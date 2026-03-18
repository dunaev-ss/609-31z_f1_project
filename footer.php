</body>
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous">
</script>

<!-- Инициализация и показ модального окна Bootstrap -->
<script>
    // Получаем элемент модального окна по его ID
    var myModalElement = document.getElementById('messageModal');

    // Создаём экземпляр модального компонента Bootstrap
    // Пустой объект {} означает использование стандартных настроек
    var myModal = new bootstrap.Modal(myModalElement, {});

    // Отображаем модальное окно сразу после загрузки страницы
    myModal.show();
</script>
</html>
