import { test, expect } from '@playwright/test';
import exp from 'constants';

test('register new user', async ({ page }) => {
    await test.slow();

    await page.goto("http://127.0.0.1:8000/login");

    await page.getByRole("link", { name: "Register"}).click();

    await page.getByPlaceholder("e.g. fulan", { exact: true }).fill("Jack");

    await page.getByPlaceholder("e.g. fulan@email.com").fill("jackjacked@gmail.com");

    await page.getByPlaceholder("Password", { exact: true }).fill("12");

    await page.getByPlaceholder("Ulangi Password").fill("12");

    await page.getByRole("button", {name: "Registrasi"}).click();

    await expect(page.getByText("Akun berhasil dibuat")).toBeVisible();

    await page.getByTestId("menus").first().click();
    await page.getByRole("link", { name: "log out Logout" }).click();

    await page.getByPlaceholder('e.g. fulan@email.com').fill("jackjacked@gmail.com");
    await page.getByPlaceholder('password').fill("12");

    await page.getByRole('button', {name: 'Login'}).click();

    await expect(page.getByText("Akun anda belum terverifikasi, silahkan verifikasi dengan mengklik tautan")).toBeVisible({timeout: 10000});
});
