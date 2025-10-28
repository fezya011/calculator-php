<div style="
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
">
    <h1 style="
        font-size: 2.5rem;
        margin-bottom: 2rem;
        color: #333;
        text-align: center;
    ">📞 Контакты</h1>

    <div style="
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
    ">
        <div>
            <h2 style="color: #667eea; margin-bottom: 1.5rem;">Свяжитесь с нами</h2>

            <div style="margin-bottom: 2rem;">
                <div style="
                    display: flex;
                    align-items: center;
                    gap: 1rem;
                    margin-bottom: 1rem;
                    padding: 1rem;
                    background: #f8f9fa;
                    border-radius: 8px;
                ">
                    <span style="font-size: 1.5rem;">📧</span>
                    <div>
                        <strong>Email</strong><br>
                        <span style="color: #666;">info@flatcms.com</span>
                    </div>
                </div>

                <div style="
                    display: flex;
                    align-items: center;
                    gap: 1rem;
                    margin-bottom: 1rem;
                    padding: 1rem;
                    background: #f8f9fa;
                    border-radius: 8px;
                ">
                    <span style="font-size: 1.5rem;">📱</span>
                    <div>
                        <strong>Телефон</strong><br>
                        <span style="color: #666;">+7 (999) 123-45-67</span>
                    </div>
                </div>

                <div style="
                    display: flex;
                    align-items: center;
                    gap: 1rem;
                    padding: 1rem;
                    background: #f8f9fa;
                    border-radius: 8px;
                ">
                    <span style="font-size: 1.5rem;">🏢</span>
                    <div>
                        <strong>Адрес</strong><br>
                        <span style="color: #666;">г. Москва, ул. Примерная, 123</span>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <h2 style="color: #667eea; margin-bottom: 1.5rem;">Форма обратной связи</h2>

            <form style="display: grid; gap: 1rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Ваше имя</label>
                    <input type="text" style="
                        width: 100%;
                        padding: 0.75rem;
                        border: 1px solid #ddd;
                        border-radius: 5px;
                        font-size: 1rem;
                    " required>
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Email</label>
                    <input type="email" style="
                        width: 100%;
                        padding: 0.75rem;
                        border: 1px solid #ddd;
                        border-radius: 5px;
                        font-size: 1rem;
                    " required>
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Сообщение</label>
                    <textarea style="
                        width: 100%;
                        padding: 0.75rem;
                        border: 1px solid #ddd;
                        border-radius: 5px;
                        font-size: 1rem;
                        min-height: 120px;
                        resize: vertical;
                    " required></textarea>
                </div>

                <button type="submit" style="
                    background: #667eea;
                    color: white;
                    border: none;
                    padding: 1rem 2rem;
                    border-radius: 5px;
                    font-size: 1rem;
                    cursor: pointer;
                    transition: background 0.3s;
                " onmouseover="this.style.background='#5a6fd8'"
                        onmouseout="this.style.background='#667eea'">
                    Отправить сообщение
                </button>
            </form>
        </div>
    </div>
</div>