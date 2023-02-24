<!DOCTYPE html>
<html>

<head>
    <title>Background Image Example</title>
    <style type="text/css">
        @font-face {
            font-family: 'Arial';
            src: url('assets/font/arial.ttf') format('truetype');
        }

        html,
        body {
            background-image: url('assets/img/bg-sertif.jpeg');
            background-repeat: no-repeat;
            background-size: cover;
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .table-bordered th td {
            border: 1px solid;
            border-collapse: collapse;
            padding: 0;
            margin: 1px;
        }

        .borderless tr td {
            border: 0px solid;
            border-collapse: none;
            line-height: 0.5;
        }

        .content {
            padding-top: 1%;
            padding-left: 5%;
            padding-right: 5%;
            padding-bottom: 5%;
        }

        .judul {
            text-align: center;
            font-size: 25px;
            font-weight: 700;
        }

        .sub-judul {
            text-align: center;
            font-size: 15px;
            font-weight: 300;
        }

        .guedi {
            border: 2px solid black;
            padding: 0px;
            margin: 0px;
        }

        .isi {
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="content">
        <table class="borderless" style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 18%; text-align: center;">
                        <img src="assets/img/logo-pemkot.png" style="width: 160px; height: 160px;" alt="logo">
                    </td>
                    <td style="padding-right: 22%;">
                        <div class="judul">
                            <p style="padding-top: 8px;">
                                PEMERINTAH KOTA KEDIRI <br><br>
                                <span class="judul">
                                    DINAS PENDIDIKAN
                                </span><br><br>
                                <span class="sub-judul">
                                    JALAN MAYOR BISMO NO. 10-12 TELP. (0354) 689923 FAX. (0354) 690556
                                </span><br><br>
                                <span class="sub-judul">
                                    SITUS: DISPENDIK.KEDIRIKOTA.GO.ID EMAIL:DISPENDIK@KEDIRIKOTA.GO.ID
                                </span><br><br>
                                <span class="sub-judul">
                                    KEDIRI
                                </span>
                            </p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr>
                        <hr class="guedi">
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="isi">
            <center style="padding-top: 5px;">
                <b style="font-size: 13px;"><u>SURAT KETERANGAN</u></b>
                <p style="margin: 0;">No. 421.4/1814/419.109/2022</p>
            </center>
        </div>
    </div>
</body>

</html>