@extends('layouts.app')

@section('title', 'Lupa Password')
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

.forgot-page {
    width: 100%;
    min-height: 100vh;
    background: var(--white);
    border: 4px solid var(--black);
    position: relative;
    overflow: hidden;
    padding: 44px 70px;
    display: grid;
    grid-template-columns: 520px 540px;
    justify-content: center;
    align-items: center;
    gap: 70px;
}

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
    top: 36%;
    z-index: 1;
}

.dots-left {
    position: absolute;
    left: 10%;
    top: 35%;
    display: grid;
    grid-template-columns: repeat(4, 8px);
    gap: 13px;
    z-index: 1;
}

.dots-bottom {
    position: absolute;
    left: 35%;
    bottom: 84px;
    display: grid;
    grid-template-columns: repeat(4, 8px);
    gap: 15px;
    z-index: 1;
}

.dots-left span,
.dots-bottom span {
    width: 8px;
    height: 8px;
    background: var(--black);
}

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
    overflow: hidden;
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
    overflow: hidden;
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

.info-box {
    width: 470px;
    min-height: 104px;
    background: var(--green);
    border: 5px solid var(--black);
    box-shadow: 9px 9px 0 var(--black);
    display: grid;
    grid-template-columns: 84px 1fr;
    gap: 18px;
    align-items: center;
    padding: 14px 20px;
}

.shield-box {
    width: 78px;
    height: 78px;
    display: grid;
    place-items: center;
}

.shield-box svg {
    width: 78px;
    height: 78px;
    stroke: var(--black);
    stroke-width: 3.2;
    fill: #fff;
}

.info-text h3 {
    margin: 0;
    font-size: 20px;
    line-height: 1.08;
    font-weight: 900;
}

.info-text p {
    margin: 8px 0 0;
    max-width: 330px;
    font-size: 14px;
    line-height: 1.25;
}

.right-side {
    width: 540px;
}

.forgot-card {
    width: 100%;
    background: #fff;
    border: 5px solid var(--black);
    box-shadow: 13px 13px 0 var(--black);
    padding: 30px 36px;
}

.card-title {
    width: 100%;
    min-height: 64px;
    margin: 0 auto 28px;
    background: var(--yellow);
    border: 5px solid var(--black);
    box-shadow: 8px 8px 0 var(--black);
    display: grid;
    grid-template-columns: 58px 1fr;
    align-items: center;
    gap: 16px;
    padding: 8px 18px;
    font-size: 34px;
    line-height: 1;
    font-weight: 900;
    text-align: left;
    white-space: nowrap;
}

.title-icon {
    width: 52px;
    height: 52px;
    background: #fff;
    border: 4px solid var(--black);
    display: grid;
    place-items: center;
}

.title-icon svg {
    width: 34px;
    height: 34px;
    stroke: var(--black);
    stroke-width: 3.2;
    fill: none;
}

.desc {
    font-size: 18px;
    line-height: 1.25;
    font-weight: 700;
    margin: 0 0 28px;
    max-width: 400px;
}

.alert {
    border: 4px solid var(--black);
    box-shadow: 5px 5px 0 var(--black);
    padding: 10px 14px;
    margin-bottom: 18px;
    font-weight: 900;
    font-size: 14px;
}

.alert.error {
    background: var(--red);
}

.alert.success {
    background: var(--green);
}

.form-group {
    margin-bottom: 26px;
}

.form-label {
    display: block;
    font-size: 21px;
    font-weight: 900;
    margin-bottom: 9px;
}

.input-wrap {
    position: relative;
}

.input-wrap input {
    width: 100%;
    height: 58px;
    background: #fff;
    border: 4px solid var(--black);
    outline: none;
    padding: 0 58px 0 58px;
    font-size: 18px;
}

.input-wrap input:focus {
    box-shadow: 5px 5px 0 var(--black);
}

.input-icon {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    width: 29px;
    height: 29px;
    stroke: var(--black);
    stroke-width: 3.2;
    fill: none;
}

.error-text {
    margin-top: 7px;
    color: #b00000;
    font-size: 13px;
    font-weight: 900;
}

.send-btn {
    width: 100%;
    height: 62px;
    background: var(--blue);
    border: 5px solid var(--black);
    box-shadow: 8px 8px 0 var(--black);
    font-size: 27px;
    font-weight: 900;
    cursor: pointer;
    margin-top: 4px;
}

.send-btn:active {
    transform: translate(5px, 5px);
    box-shadow: 3px 3px 0 var(--black);
}

.back-link {
    border-top: 4px solid var(--black);
    margin-top: 32px;
    padding-top: 18px;
    text-align: center;
    font-size: 18px;
    font-weight: 900;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
}

.back-link a {
    color: #004cff;
    font-weight: 900;
}

.back-link svg {
    width: 30px;
    height: 30px;
    stroke: var(--black);
    stroke-width: 3.5;
    fill: none;
}

@media (max-width: 1400px) {
    body {
        overflow-y: auto;
    }

    .forgot-page {
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
        width: min(540px, 92vw);
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
    .dots-left,
    .dots-bottom {
        display: none;
    }

    .red-box {
        right: 40px;
        top: 112px;
        width: 52px;
        height: 52px;
    }
}

@media (max-width: 620px) {
    .forgot-page {
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

    .shield-box {
        width: 58px;
        height: 58px;
    }

    .shield-box svg {
        width: 58px;
        height: 58px;
    }

    .info-text h3 {
        font-size: 17px;
    }

    .info-text p {
        font-size: 12.5px;
        margin-top: 6px;
        max-width: 100%;
    }

    .forgot-card {
        border-width: 4px;
        box-shadow: 9px 9px 0 var(--black);
        padding: 24px 20px;
    }

    .card-title {
        min-height: 58px;
        font-size: 26px;
        border-width: 4px;
        box-shadow: 6px 6px 0 var(--black);
        margin-bottom: 24px;
        padding: 8px 12px;
        grid-template-columns: 46px 1fr;
        gap: 12px;
        white-space: normal;
    }

    .title-icon {
        width: 44px;
        height: 44px;
        border-width: 3px;
    }

    .title-icon svg {
        width: 28px;
        height: 28px;
    }

    .desc {
        font-size: 15px;
    }

    .form-label {
        font-size: 18px;
    }

    .input-wrap input {
        height: 54px;
        border-width: 3px;
        font-size: 16px;
        padding-left: 50px;
    }

    .input-icon {
        left: 15px;
        width: 25px;
        height: 25px;
    }

    .send-btn {
        height: 58px;
        border-width: 4px;
        box-shadow: 6px 6px 0 var(--black);
        font-size: 22px;
    }

    .back-link {
        font-size: 16px;
        margin-top: 28px;
    }
}

@media (max-width: 430px) {
    .forgot-page {
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

    .forgot-card {
        padding: 22px 16px;
    }

    .card-title {
        font-size: 23px;
    }

    .send-btn {
        font-size: 20px;
    }

    .back-link {
        font-size: 15px;
        flex-wrap: wrap;
    }
}
</style>
@endsection

@section('content')
<div class="forgot-page">

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

    <div class="dots-left">
        <span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span><span></span>
    </div>

    <div class="dots-bottom">
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
            <div class="shield-box">
                <svg viewBox="0 0 80 80">
                    <path d="M40 6L66 16V34C66 54 53 68 40 74C27 68 14 54 14 34V16L40 6Z"></path>
                    <rect x="28" y="34" width="24" height="24" rx="3" fill="#ffd83d"></rect>
                    <path d="M33 34V27C33 23 36 20 40 20C44 20 47 23 47 27V34"></path>
                    <path d="M40 43V50"></path>
                </svg>
            </div>

            <div class="info-text">
                <h3>Bantuan Akun</h3>
                <p>Kami akan mengirim kode OTP ke email kamu</p>
            </div>
        </div>
    </section>

    <section class="right-side">
        <div class="forgot-card">
            <div class="card-title">
                <div class="title-icon">
                    <svg viewBox="0 0 64 64">
                        <rect x="8" y="16" width="48" height="34" rx="3"></rect>
                        <path d="M8 20l24 18 24-18"></path>
                    </svg>
                </div>
                <span>Lupa Password</span>
            </div>

            <p class="desc">
                Masukkan email akun kamu untuk menerima kode OTP reset password.
            </p>

            @if(session('success'))
                <div class="alert success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert error">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.otp.send') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Email</label>

                    <div class="input-wrap">
                        <svg class="input-icon" viewBox="0 0 64 64">
                            <rect x="8" y="16" width="48" height="34" rx="3"></rect>
                            <path d="M8 20l24 18 24-18"></path>
                        </svg>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            required
                        >
                    </div>

                    @error('email')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="send-btn">Kirim Kode OTP</button>
            </form>

            <div class="back-link">
                <svg viewBox="0 0 64 64">
                    <path d="M36 14L18 32L36 50"></path>
                    <path d="M20 32H54"></path>
                </svg>

                <a href="{{ route('login') }}">Kembali ke Login</a>
            </div>
        </div>
    </section>

</div>
@endsection
