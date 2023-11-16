import { test, expect } from '@playwright/test';
import exp from 'constants';

test('forget password', async ({ page }) => {
    await test.slow();

    await page.goto("http://127.0.0.1:8000/login");

    await page.getByRole("link", { name: "Lupa password"}).click();

    await expect(page.getByText("Lupa Password")).toBeVisible({ timeout: 30000 });

    await expect(page.getByLabel("Email")).toHaveAttribute("type","email");
    
    await page.getByLabel("Email").fill("hanifnandaafrian7@gmail.com");

    await expect(page.getByRole("button", { name: "kirim Kode" })).toBeVisible({ timeout: 30000 });

    await page.getByRole("button", { name: "Kirim Kode" }).click(); 


    await expect(page.getByText("Email tidak ada")).toBeVisible({ timeout: 30000 });

    await expect(page.getByRole("heading", { name: "Ketikan Password Baru" })).toBeVisible({ timeout: 30000 });
    
    await expect(page.getByLabel("Kode Konfirmasi")).toHaveAttribute("type","text");

    await expect(page.getByPlaceholder('Password baru kamu', { exact: true })).toHaveAttribute("type","password");
    await expect(page.getByPlaceholder('Ulangi password baru kamu')).toHaveAttribute("type","password");

    await expect(page.getByRole('img', { name: "eye-pass", exact: true })).toBeVisible({timeout: 30000});
    await page.getByRole('img', { name: "eye-pass", exact: true }).click();
    await expect(page.getByRole('img', { name: "eye-pass-repeated", exact: true })).toBeVisible({timeout: 30000});
    await page.getByRole('img', { name: "eye-pass-repeated", exact: true }).click();

    await expect(page.getByPlaceholder('Password baru kamu', { exact: true })).toHaveAttribute("type","text");
    await expect(page.getByPlaceholder('Ulangi Password baru kamu')).toHaveAttribute("type","text");

    await page.getByRole("button", { name: "Ubah Password" }).click();

    await expect(page.getByText("kode tidak valid, silahkan cek kode anda!")).toBeVisible({ timeout: 30000 });
    await expect(page.getByText("kode tidak valid, silahkan cek kode anda!")).toHaveClass("text-red-500");
});
