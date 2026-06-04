@extends('layouts.app')

@section('title', 'Register Pasien')
@section('body-class', 'auth-body')

@section('extra-css')
<style>
:root {
    --black: #000;
    --white: #fffdf7;
    --yellow: #ffd83d;
    --blue: #28bff3;
    --green: #8be8b0;
    --red: #ff6868;
}

* {
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

html,
body {
    margin: 0;
    width: 100%;
    min-height: 100%;
    background: var(--white);
    color: var(--black);
}

body {
    overflow-x: hidden;
}

/* ===================== */
/* PAGE */
/* ===================== */

.register-page {
    width: 100%;
    min-height: 100vh;
    background: var(--white);
    border: 4px solid var(--black);
    position: relative;
    overflow: hidden;
    padding: 44px 70px;
    display: grid;
    grid-template-columns: 520px 610px;
    justify-content: center;
    align-items: center;
    gap: 70px;
}

/* ===================== */
/* DECORATION */
/* ===================== */

.corner-left {
    position: absolute;
    left: -4px;
    top: -4px;
    width: 105px;
    z-index: 1;
}

.corner-left span {
    display: block;
    background: var(--blue);
    border-right: 4px solid var(--black);
    border-bottom: 4px solid var(--black);
    height: 45px;
}

.corner-left span:nth-child(1) {
    width: 105px;
}

.corner-left span:nth-child(2) {
    width: 70px;
}

.corner-left span:nth-child(3) {
    width: 38px;
}

.corner-yellow {
    position: absolute;
    left: -4px;
    bottom: -4px;
    width: 260px;
    z-index: 1;
}

.corner-yellow span {
    display: block;
    background: var(--yellow);
    border-top: 4px solid var(--black);
    border-right: 4px solid var(--black);
    height: 61px;
}

.corner-yellow span:nth-child(1) {
    width: 120px;
}

.corner-yellow span:nth-child(2) {
    width: 205px;
}

.corner-yellow span:nth-child(3) {
    width: 260px;
}

.corner-blue {
    position: absolute;
    right: -4px;
    bottom: -4px;
    width: 145px;
    z-index: 1;
}

.corner-blue span {
    display: block;
    margin-left: auto;
    background: var(--blue);
    border-top: 4px solid var(--black);
    border-left: 4px solid var(--black);
    height: 67px;
}

.corner-blue span:nth-child(1) {
    width: 48px;
}

.corner-blue span:nth-child(2) {
    width: 92px;
}

.corner-blue span:nth-child(3) {
    width: 145px;
}

.red-box {
    position: absolute;
    width: 66px;
    height: 66px;
    background: var(--red);
    border: 4px solid var(--black);
    box-shadow: 8px 8px 0 var(--black);
    right: 76px;
    top: 118px;
    z-index: 1;
}

.small-green {
    position: absolute;
    width: 30px;
    height: 30px;
    background: var(--green);
    border: 4px solid var(--black);
    box-shadow: 5px 5px 0 var(--black);
    left: 43%;
    top: 45%;
    z-index: 1;
}

.dots {
    position: absolute;
    left: 18%;
    bottom: 84px;
    display: grid;
    grid-template-columns: repeat(4, 8px);
    gap: 15px;
    z-index: 1;
}

.dots span {
    width: 8px;
    height: 8px;
    background: var(--black);
}

/* ===================== */
/* LEFT */
/* ===================== */

.left-side,
.right-side {
    position: relative;
    z-index: 2;
}

.left-side {
    width: 520px;
}

.brand {
    display: flex;
    align-items: center;
    gap: 22px;
}

.logo-box {
    width: 130px;
    height: 130px;
    background: #fff;
    border: 5px solid var(--black);
    box-shadow: 8px 8px 0 var(--black);
    display: grid;
    place-items: center;
    flex-shrink: 0;
}

.logo-box svg {
    width: 88px;
    height: 88px;
}

.brand-title {
    line-height: 1;
    font-weight: 900;
}

.auth-brand-title {
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-transform: uppercase;
}

.auth-brand-small {
    font-size: 32px;
    font-weight: 900;
    letter-spacing: 9px;
    line-height: .9;
}

.auth-brand-big {
    font-size: 52px;
    font-weight: 900;
    letter-spacing: 2px;
    line-height: .95;
}

.auth-brand-line {
    width: 165px;
    height: 6px;
    background: var(--black);
    margin-top: 10px;
}

.brand-line {
    width: 100%;
    height: 5px;
    background: var(--black);
    margin: 26px 0 25px;
}

.icon-row {
    display: flex;
    gap: 24px;
    margin-bottom: 32px;
}

.icon-card {
    width: 82px;
    height: 82px;
    border: 5px solid var(--black);
    box-shadow: 8px 8px 0 var(--black);
    display: grid;
    place-items: center;
    background: var(--yellow);
    flex-shrink: 0;
}

.icon-card.red {
    background: var(--red);
}

.icon-card.green {
    background: var(--green);
}

.icon-card.blue {
    background: var(--blue);
}

.icon-card svg {
    width: 48px;
    height: 48px;
    stroke: var(--black);
    stroke-width: 3.5;
    fill: none;
}

/* INFO BOX SAMA KAYA LOGIN */
.info-box {
    width: 470px;
    min-height: 128px;
    background: var(--green);
    border: 5px solid var(--black);
    box-shadow: 9px 9px 0 var(--black);
    display: grid;
    grid-template-columns: 78px 1fr;
    gap: 18px;
    align-items: center;
    padding: 16px 20px;
}

.avatar-box {
    width: 68px;
    height: 68px;
    background: #fff;
    border: 5px solid var(--black);
    display: grid;
    place-items: center;
}

.avatar-box svg {
    width: 48px;
    height: 48px;
    stroke: var(--black);
    stroke-width: 3.5;
    fill: var(--red);
}

.info-text h3 {
    margin: 0;
    font-size: 21px;
    line-height: 1.08;
    font-weight: 900;
}

.info-text p {
    margin: 8px 0 0;
    max-width: 330px;
    font-size: 14px;
    line-height: 1.25;
}

/* ===================== */
/* RIGHT REGISTER */
/* ===================== */

.right-side {
    width: 610px;
}

.register-card {
    width: 100%;
    background: #fff;
    border: 5px solid var(--black);
    box-shadow: 13px 13px 0 var(--black);
    padding: 24px 32px 26px;
}

.card-title {
    width: 390px;
    min-height: 58px;
    margin: 0 auto 12px;
    background: var(--yellow);
    border: 5px solid var(--black);
    box-shadow: 8px 8px 0 var(--black);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 8px 18px;
    font-size: 30px;
    line-height: 1;
    font-weight: 900;
    text-align: center;
}

.subtitle {
    margin: 0 0 12px;
    font-size: 16px;
    font-weight: 900;
}

.alert {
    border: 4px solid var(--black);
    box-shadow: 5px 5px 0 var(--black);
    padding: 8px 12px;
    margin-bottom: 12px;
    background: var(--red);
    font-weight: 900;
    font-size: 13px;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px 22px;
}

.form-group {
    min-width: 0;
}

.form-label {
    display: block;
    font-size: 14.5px;
    font-weight: 900;
    margin-bottom: 5px;
}

.input-wrap {
    position: relative;
}

.input-wrap input,
.input-wrap select {
    width: 100%;
    height: 40px;
    background: #fff;
    border: 4px solid var(--black);
    outline: none;
    padding: 0 42px 0 42px;
    font-size: 14px;
}

.input-wrap input:focus,
.input-wrap select:focus {
    box-shadow: 4px 4px 0 var(--black);
}

.input-wrap select {
    appearance: none;
    cursor: pointer;
}

.input-icon {
    position: absolute;
    left: 13px;
    top: 50%;
    transform: translateY(-50%);
    width: 21px;
    height: 21px;
    stroke: var(--black);
    stroke-width: 3.2;
    fill: none;
    pointer-events: none;
}

.select-arrow {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    width: 22px;
    height: 22px;
    stroke: var(--black);
    stroke-width: 3.2;
    fill: none;
    pointer-events: none;
}

.eye-btn {
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
    border: 0;
    background: transparent;
    width: 30px;
    height: 30px;
    cursor: pointer;
    display: grid;
    place-items: center;
    padding: 0;
}

.eye-btn svg {
    width: 23px;
    height: 23px;
    stroke: var(--black);
    stroke-width: 3.2;
    fill: none;
}

.error-text {
    margin-top: 4px;
    color: #b00000;
    font-size: 11px;
    font-weight: 900;
}

.register-btn {
    width: 100%;
    height: 52px;
    background: var(--blue);
    border: 5px solid var(--black);
    box-shadow: 8px 8px 0 var(--black);
    font-size: 25px;
    font-weight: 900;
    cursor: pointer;
    margin-top: 18px;
}

.register-btn:active {
    transform: translate(5px, 5px);
    box-shadow: 3px 3px 0 var(--black);
}

.bottom-link {
    border-top: 4px solid var(--black);
    margin-top: 22px;
    padding-top: 14px;
    text-align: center;
    font-size: 16px;
}

.bottom-link a {
    color: #004cff;
    font-weight: 900;
}

/* ===================== */
/* RESPONSIVE LAPTOP */
/* ===================== */

@media (max-width: 1400px) {
    body {
        overflow-y: auto;
    }

    .register-page {
        min-height: 100vh;
        grid-template-columns: 1fr;
        justify-items: center;
        align-items: start;
        gap: 30px;
        padding: 36px 28px 120px;
        overflow: hidden;
    }

    .left-side {
        width: min(560px, 92vw);
    }

    .right-side {
        width: min(610px, 92vw);
    }

    .brand {
        justify-content: center;
    }

    .brand-line {
        width: 100%;
    }

    .icon-row {
        justify-content: center;
        margin-bottom: 28px;
    }

    .info-box {
        width: 100%;
    }

    .small-green,
    .dots {
        display: none;
    }

    .red-box {
        right: 40px;
        top: 112px;
        width: 52px;
        height: 52px;
    }
}

/* ===================== */
/* TABLET */
/* ===================== */

@media (max-width: 760px) {
    .form-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .card-title {
        width: 100%;
    }

    .subtitle {
        text-align: center;
    }

    .input-wrap input,
    .input-wrap select {
        height: 48px;
    }
}

/* ===================== */
/* HP */
/* ===================== */

@media (max-width: 620px) {
    .register-page {
        border-width: 3px;
        padding: 26px 16px 96px;
        gap: 24px;
    }

    .corner-left {
        width: 74px;
    }

    .corner-left span {
        height: 35px;
    }

    .corner-left span:nth-child(1) {
        width: 74px;
    }

    .corner-left span:nth-child(2) {
        width: 50px;
    }

    .corner-left span:nth-child(3) {
        width: 30px;
    }

    .corner-yellow {
        width: 160px;
    }

    .corner-yellow span {
        height: 40px;
    }

    .corner-yellow span:nth-child(1) {
        width: 74px;
    }

    .corner-yellow span:nth-child(2) {
        width: 122px;
    }

    .corner-yellow span:nth-child(3) {
        width: 160px;
    }

    .corner-blue {
        width: 96px;
    }

    .corner-blue span {
        height: 46px;
    }

    .corner-blue span:nth-child(1) {
        width: 32px;
    }

    .corner-blue span:nth-child(2) {
        width: 64px;
    }

    .corner-blue span:nth-child(3) {
        width: 96px;
    }

    .red-box {
        display: none;
    }

    .left-side,
    .right-side {
        width: calc(100vw - 36px);
    }

    .brand {
        gap: 14px;
        justify-content: center;
    }

    .logo-box {
        width: 84px;
        height: 84px;
        border-width: 4px;
        box-shadow: 6px 6px 0 var(--black);
    }

    .logo-box svg {
        width: 58px;
        height: 58px;
    }

    .brand-title {
        font-size: 29px;
    }

    .brand-line {
        height: 4px;
        margin: 22px 0 20px;
    }

    .icon-row {
        width: 100%;
        gap: 11px;
        margin-bottom: 24px;
        flex-wrap: nowrap;
    }

    .icon-card {
        width: 60px;
        height: 60px;
        border-width: 4px;
        box-shadow: 6px 6px 0 var(--black);
    }

    .icon-card svg {
        width: 35px;
        height: 35px;
    }

    .info-box {
        grid-template-columns: 64px 1fr;
        gap: 12px;
        padding: 14px;
        border-width: 4px;
        box-shadow: 7px 7px 0 var(--black);
    }

    .avatar-box {
        width: 58px;
        height: 58px;
        border-width: 4px;
    }

    .avatar-box svg {
        width: 40px;
        height: 40px;
    }

    .info-text h3 {
        font-size: 17px;
    }

    .info-text p {
        font-size: 12.5px;
        margin-top: 6px;
        max-width: 100%;
    }

    .register-card {
        border-width: 4px;
        box-shadow: 9px 9px 0 var(--black);
        padding: 24px 18px 22px;
    }

    .card-title {
        min-height: 54px;
        font-size: 24px;
        border-width: 4px;
        box-shadow: 6px 6px 0 var(--black);
        margin-bottom: 12px;
    }

    .subtitle {
        font-size: 15px;
    }

    .form-label {
        font-size: 15px;
    }

    .input-wrap input,
    .input-wrap select {
        height: 50px;
        border-width: 3px;
        font-size: 15px;
        padding-left: 48px;
    }

    .input-icon {
        left: 14px;
        width: 24px;
        height: 24px;
    }

    .register-btn {
        height: 58px;
        border-width: 4px;
        box-shadow: 6px 6px 0 var(--black);
        font-size: 24px;
    }

    .bottom-link {
        font-size: 16px;
    }
}

/* ===================== */
/* HP CILIK */
/* ===================== */

@media (max-width: 430px) {
    .register-page {
        padding-left: 12px;
        padding-right: 12px;
    }

    .left-side,
    .right-side {
        width: calc(100vw - 36px);
    }

    .brand {
        justify-content: center;
        gap: 12px;
    }

    .logo-box {
        width: 72px;
        height: 72px;
    }

    .logo-box svg {
        width: 50px;
        height: 50px;
    }

    .brand-title {
        font-size: 24px;
    }

    .icon-row {
        justify-content: center;
        gap: 9px;
    }

    .icon-card {
        width: 52px;
        height: 52px;
    }

    .icon-card svg {
        width: 30px;
        height: 30px;
    }

    .info-box {
        grid-template-columns: 1fr;
        text-align: center;
        justify-items: center;
    }

    .info-text h3 {
        font-size: 17px;
    }

    .register-card {
        padding: 22px 16px;
    }

    .card-title {
        font-size: 22px;
    }

    .bottom-link {
        font-size: 15px;
    }
}
</style>
@endsection

@section('content')
<div class="register-page">

    <div class="corner-left">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <div class="corner-yellow">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <div class="corner-blue">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <div class="red-box"></div>
    <div class="small-green"></div>

    <div class="dots">
        <span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span><span></span>
    </div>

    <section class="left-side">
        <div class="brand">
            <div class="logo-box">
                <svg viewBox="0 0 100 100">
                    <path d="M38 8H62V38H92V62H62V92H38V62H8V38H38Z"
                          fill="#8be8b0" stroke="#000" stroke-width="7" stroke-linejoin="round"/>
                </svg>
            </div>

            <div class="brand-title auth-brand-title">
                <span class="auth-brand-small">KLINIK</span>
                <span class="auth-brand-big">SEHATI</span>
                <span class="auth-brand-line"></span>
            </div>
        </div>

        <div class="brand-line"></div>

        <div class="icon-row">
            <div class="icon-card">
                <svg viewBox="0 0 64 64">
                    <rect x="17" y="12" width="30" height="44" rx="3"></rect>
                    <path d="M25 12h14v-4H25z"></path>
                    <path d="M32 24v14M25 31h14"></path>
                    <path d="M24 44h16"></path>
                </svg>
            </div>

            <div class="icon-card red">
                <svg viewBox="0 0 64 64">
                    <path d="M32 52S10 39 10 23c0-8 6-13 13-13 5 0 8 3 9 6 1-3 4-6 9-6 7 0 13 5 13 13 0 16-22 29-22 29z"></path>
                    <path d="M16 32h10l4-10 6 20 5-10h7"></path>
                </svg>
            </div>

            <div class="icon-card green">
                <svg viewBox="0 0 64 64">
                    <path d="M20 12v18c0 8 5 14 12 14s12-6 12-14V12"></path>
                    <path d="M16 12h8M40 12h8"></path>
                    <circle cx="48" cy="48" r="7"></circle>
                    <path d="M44 44l-5-5"></path>
                </svg>
            </div>

            <div class="icon-card blue">
                <svg viewBox="0 0 64 64">
                    <rect x="24" y="14" width="16" height="40" rx="3"></rect>
                    <path d="M27 14V8h10v6"></path>
                    <path d="M32 28v14M26 35h12"></path>
                </svg>
            </div>
        </div>

        <div class="info-box">
            <div class="avatar-box">
                <svg viewBox="0 0 64 64">
                    <circle cx="32" cy="22" r="12"></circle>
                    <path d="M12 56c3-14 13-22 20-22s17 8 20 22"></path>
                </svg>
            </div>

            <div class="info-text">
                <h3>Pelayanan Kesehatan<br>Lebih Mudah & Terpercaya</h3>
                <p>Daftar sekarang untuk mendapatkan layanan kesehatan terbaik di klinik kami.</p>
            </div>
        </div>
    </section>

    <section class="right-side">
        <div class="register-card">
            <div class="card-title">Register Pasien</div>
            <p class="subtitle">Buat akun baru</p>

            @if($errors->any())
                <div class="alert">
                    Periksa lagi data yang kamu isi.
                </div>
            @endif

            <form method="POST" action="{{ route('register.proses') }}">
                @csrf

                <div class="form-grid">

                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <div class="input-wrap">
                            <svg class="input-icon" viewBox="0 0 64 64">
                                <circle cx="32" cy="22" r="12"></circle>
                                <path d="M12 56c3-14 13-22 20-22s17 8 20 22"></path>
                            </svg>
                            <input type="text" name="name" value="{{ old('name') }}" required>
                        </div>
                        @error('name') <div class="error-text">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">NIK</label>
                        <div class="input-wrap">
                            <svg class="input-icon" viewBox="0 0 64 64">
                                <rect x="10" y="16" width="44" height="32" rx="3"></rect>
                                <circle cx="24" cy="31" r="5"></circle>
                                <path d="M18 43c2-6 5-8 6-8s4 2 6 8"></path>
                                <path d="M35 26h12M35 34h12"></path>
                            </svg>
                            <input type="text" name="nik" value="{{ old('nik') }}" required>
                        </div>
                        @error('nik') <div class="error-text">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tanggal Lahir</label>
                        <div class="input-wrap">
                            <svg class="input-icon" viewBox="0 0 64 64">
                                <rect x="10" y="14" width="44" height="42" rx="3"></rect>
                                <path d="M20 8v12M44 8v12M10 26h44"></path>
                                <path d="M22 36h8M36 36h8M22 46h8"></path>
                            </svg>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                        </div>
                        @error('tanggal_lahir') <div class="error-text">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jenis Kelamin</label>
                        <div class="input-wrap">
                            <svg class="input-icon" viewBox="0 0 64 64">
                                <circle cx="32" cy="22" r="12"></circle>
                                <path d="M12 56c3-14 13-22 20-22s17 8 20 22"></path>
                            </svg>

                            <select name="jenis_kelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>

                            <svg class="select-arrow" viewBox="0 0 64 64">
                                <path d="M18 24l14 16 14-16"></path>
                            </svg>
                        </div>
                        @error('jenis_kelamin') <div class="error-text">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Alamat</label>
                        <div class="input-wrap">
                            <svg class="input-icon" viewBox="0 0 64 64">
                                <path d="M32 58s18-18 18-34A18 18 0 0 0 14 24c0 16 18 34 18 34z"></path>
                                <circle cx="32" cy="24" r="6"></circle>
                            </svg>
                            <input type="text" name="alamat" value="{{ old('alamat') }}" required>
                        </div>
                        @error('alamat') <div class="error-text">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">No. HP</label>
                        <div class="input-wrap">
                            <svg class="input-icon" viewBox="0 0 64 64">
                                <path d="M22 10l8 14-7 5c4 8 9 13 17 17l5-7 14 8c-2 8-7 12-14 12C24 59 5 40 5 19c0-7 4-12 12-14z"></path>
                            </svg>
                            <input type="text" name="no_hp" value="{{ old('no_hp') }}" required>
                        </div>
                        @error('no_hp') <div class="error-text">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <div class="input-wrap">
                            <svg class="input-icon" viewBox="0 0 64 64">
                                <rect x="8" y="16" width="48" height="34" rx="3"></rect>
                                <path d="M8 20l24 18 24-18"></path>
                            </svg>
                            <input type="email" name="email" value="{{ old('email') }}" required>
                        </div>
                        @error('email') <div class="error-text">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-wrap">
                            <svg class="input-icon" viewBox="0 0 64 64">
                                <rect x="14" y="28" width="36" height="27" rx="4"></rect>
                                <path d="M22 28V18a10 10 0 0 1 20 0v10"></path>
                                <path d="M32 39v7"></path>
                            </svg>

                            <input id="passwordInput" type="password" name="password" required>

                            <button type="button" class="eye-btn" onclick="togglePassword()">
                                <svg id="eyeOpen" viewBox="0 0 64 64">
                                    <path d="M6 32s10-16 26-16 26 16 26 16-10 16-26 16S6 32 6 32z"></path>
                                    <circle cx="32" cy="32" r="7"></circle>
                                </svg>

                                <svg id="eyeClosed" viewBox="0 0 64 64" style="display:none;">
                                    <path d="M6 32s10-16 26-16 26 16 26 16-10 16-26 16S6 32 6 32z"></path>
                                    <circle cx="32" cy="32" r="7"></circle>
                                    <path d="M12 56L56 8"></path>
                                </svg>
                            </button>
                        </div>
                        @error('password') <div class="error-text">{{ $message }}</div> @enderror
                    </div>

                </div>

                <button type="submit" class="register-btn">REGISTER</button>
            </form>

            <div class="bottom-link">
                Sudah punya akun?
                <a href="{{ route('login') }}">Login</a>
            </div>
        </div>
    </section>

</div>

<script>
function togglePassword() {
    const input = document.getElementById('passwordInput');
    const eyeOpen = document.getElementById('eyeOpen');
    const eyeClosed = document.getElementById('eyeClosed');

    if (input.type === 'password') {
        input.type = 'text';
        eyeOpen.style.display = 'none';
        eyeClosed.style.display = 'block';
    } else {
        input.type = 'password';
        eyeOpen.style.display = 'block';
        eyeClosed.style.display = 'none';
    }
}
</script>
@endsection
