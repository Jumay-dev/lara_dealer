<style>
body {
    font-family: Roboto, Calibri;
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    min-height: 100vh;
    display: flex;
    justify-content: space-between;
    flex-direction: column;
}

.text--main {
    font-weight: bolder;
    color: rgb(150, 153, 156);
}

.point--title {
    font-weight: bolder;
    color: rgb(150, 153, 156);
}

.point--description {
    font-weight: bolder;
    color: rgb(102, 107, 115);
}

.header {
    margin-bottom: 2em;
    padding: 1em;
    width: 100%;
    height: 120px;
    display: flex;
    background: #f3f6f9;
    max-height: 4em;
}

.username {
    margin-bottom: 2em;
}

.footer {
    margin-top: 2em;
    padding: 1em;
    background: #e3ecf7;
}

.content--wrapper {
    padding: 1em;
}

.text-division {
    margin-top: 2em;
}
</style>
<body>
    <div class="header">
        <img src="https://ds-med.ru/wp-content/uploads/2020/03/logoDS-1.png" alt="...">
    </div>

    <div class="content--wrapper">
        <span class="point--description username">Здравствуйте, {{$user->surname . ' ' . $user->patronymic}}!</span>
        <div class="text--main">
            Ваш проект успешно добавлен в систему Ds.Med PASS и отправлен на авторизацию.
            В данный момент наши менеджеры работают над вашим оборудованием, а пока, предлагаем вам еще раз все проверить,
            и, если что-то не так, сообщите нам по электронной почте или телефону +7 (800) 555-35-35. Состав вашего проекта
            и все реквизиты отражены ниже.
        </div>

        <div class="bank-details text-division">
            <span class="point--title">Название клиники: </span> <span class="point--description">{{$clinic->name}}</span> <br>
            <span class="point--title">ИНН клиники:  </span><span class="point--description">{{$clinic->inn}}</span> <br>
            <span class="point--title">Адрес: </span><span class="point--description">{{$clinic->address}}</span>
        </div>

        <div class="tools--wrapper text-division">
            <span class="point--title">Авторизуемое оборудование</span>
            <ul class="point--title">
                <li class="point--description">Оборудование 1</li>
                <li class="point--description">Оборудование 2</li>
                <li class="point--description">Оборудование 3</li>
            </ul>
        </div>
    </div>

    <div class="footer point--description">
        С уважением,<br> <a style="text-decoration: none" class="point--description" href="https://ds-med.ru"><span style="color: blue">DS.</span><span style="color: gray">med</span></a>
    </div>
</body>
