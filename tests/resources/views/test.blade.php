<mjml>
    <mj-body background-color="#1f1f1f">
        <mj-section>
            <mj-column>
                <mj-image width="200px" src='https://api.escueladebajistas.com/mail/img/logo-white.png'
                    align="center" />
            </mj-column>
        </mj-section>
        <mj-section>
            <mj-column>
                <mj-text color="#fff">
                    <h1>Hello, {{ $name ?? ''}}</h1>
                </mj-text>

                <mj-text color="#fff">
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Numquam cumque error pariatur incidunt
                    inventore ab repellat, autem corrupti iusto voluptatum nisi nobis quod quis doloribus accusamus
                    beatae animi dolorem repellendus?
                </mj-text>
            </mj-column>
        </mj-section>

        <mj-section>

            <mj-social>
                <a href="https://www.facebook.com/escueladebajistas">
                    <mj-social-element padding="10px" name="facebook"></mj-social-element>
                </a>
                <a href="https://www.instagram.com/escueladebajistas">
                    <mj-social-element padding="10px" name="instagram"></mj-social-element>
                </a>
                <a href="https://www.youtube.com/channel/UCmwSgh_GsuLRbWIuU_evPGg">
                    <mj-social-element padding="10px" name="youtube"></mj-social-element>
                </a>
                <a href="https://twitter.com/escueladebajistas">
                    <mj-social-element padding="10px" name="twitter"></mj-social-element>
                </a>
            </mj-social>

        </mj-section>

        <mj-section>

            <mj-column>

                <mj-divider border-width="1px" border-color="lightgrey" />
                <mj-text align="center" color="#fff">
                    Este email fue enviado a sindiploma@gmail.com, pulse
                    aquí para cancelar la suscripción.
                </mj-text>
                <mj-text align='center' color="#fff">
                    Copyright © 2020 ESCUELA DE BAJISTAS Pte Ltd. Todos los derechos reservados.
                    20A Tanjong Pagar Road, 088443 Singapore, Singapore
                </mj-text>

            </mj-column>

        </mj-section>
    </mj-body>
</mjml>