import { test, expect } from '@playwright/test';

test('change password in correct way', async ({ page }) => {
    await test.slow();
  
    await page.goto("http://127.0.0.1:8000/login");
  
    await page.getByPlaceholder('e.g. fulan@email.com').fill("superma@gmail.com");
    await page.getByPlaceholder('password').fill("123");

    await page.getByRole('img', { name: 'eye-pass', exact: true }).click();
  
    await page.getByRole('button', {name: 'Login'}).click();
  
    await page.getByRole("link", {name:"berikut"}).click();
  
    await page.getByRole("link", {name: "Ubah Password"}).click();
  
    await page.getByLabel("Password Lama").fill("123");
    await page.getByRole('img', { name: 'old-pass-eye', exact: true }).click();
    
    await page.getByLabel("Password", { exact: true }).fill("1234");
  
    await page.getByLabel("Ulangi Password").fill("1234");
  
    await page.getByRole("button", { name: "Ubah Password" }).click();
  
    await expect(page.getByLabel("Password Lama")).toBeEmpty({ timeout: 20000 });
    await expect(page.getByLabel("Password", { exact: true })).toBeEmpty({ timeout: 20000 });
    await expect(page.getByLabel("Ulangi Password")).toBeEmpty({ timeout: 20000});

    await expect(page.getByText("password berhasil diganti")).toBeVisible({ timeout: 20000 });
  
    await page.getByText("Kembali").click();
  
    await page.getByTestId("menus").first().click();
    await page.getByRole("link", { name: "log out Logout" }).click();
  
    await page.getByPlaceholder('e.g. fulan@email.com').fill("superma@gmail.com");
    await page.getByPlaceholder('password').fill("1234");

    await page.getByRole('button', {name: 'Login'}).click();
    
    await expect(page.getByText("Dapatkan kesempatan magang bersama Jetorbit")).toBeVisible({ timeout: 20000 });
  })
  