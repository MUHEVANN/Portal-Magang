import { test, expect } from '@playwright/test';

test('change password and get wrong old password', async ({ page }) => {
  
  await test.slow();

  await page.goto("http://127.0.0.1:8000/login");

  await page.getByPlaceholder('e.g. fulan@email.com').fill("superma@gmail.com");
  await page.getByPlaceholder('password').fill("123");

  await page.getByRole('button', {name: 'Login'}).click();

  await expect(page.getByText("Akun anda belum terverifikasi, silahkan verifikasi dengan mengklik tautan")).toBeVisible({ timeout: 20000 });
  
  await expect(page.getByRole("button", {name: "Lamar Magang"})).toBeDisabled();

  await page.getByRole("link", {name:"berikut"}).click();

  // await expect(page.getByLabel("Email")).toHaveValue("superma@gmail.com");
  await expect(page.getByRole("button", {name: "Verifikasi"})).toBeEnabled({ timeout: 20000 });

  await page.getByRole("link", {name: "Ubah Password"}).click();
  
  await expect(page.getByLabel("Password Lama")).toHaveAttribute("type", "password", {timeout: 20000});
  await expect(page.getByLabel("Password", { exact: true })).toHaveAttribute("type", "password",{timeout: 20000});
  await expect(page.getByLabel("Ulangi Password")).toHaveAttribute("type", "password",{timeout: 20000});

    // cek eye functionality

  let alts = ['old-pass-eye','new-pass-eye','repeat-new-pass-eye']

  for (let i = 0; i < 3; i++) {
    await expect(page.getByRole('img', { name: alts[i], exact: true })).toBeVisible({timeout: 20000});
    await page.getByRole('img', { name: alts[i], exact: true }).click();
  }

  await expect(page.getByLabel("Password Lama")).toHaveAttribute("type", "text", {timeout: 20000});
  await expect(page.getByLabel("Password", { exact: true })).toHaveAttribute("type", "text", {timeout: 20000});
  await expect(page.getByLabel("Ulangi Password")).toHaveAttribute("type", "text", {timeout: 20000});
  
  
  await page.getByLabel("Password Lama").fill("1234");

  await page.getByLabel("Password", { exact: true }).fill("123");
  
  await page.getByLabel("Ulangi Password").fill("123");


  // await expect(page.getByAltText('new-pass-eye')).toBeVisible();
  // await page.getByAltText('new-pass-eye').click();

  await page.getByRole("button", { name: "Ubah Password" }).click();

  await expect(page.getByText('Password lama tidak sama')).toBeVisible({ timeout: 20000 });
  await expect(page.getByText('Password lama tidak sama')).toHaveClass(/text-red-500/);
});

test('change password and get wrong with repeated-password', async ({ page }) => {
  await test.slow();

  await page.goto("http://127.0.0.1:8000/login");

  await page.getByPlaceholder('e.g. fulan@email.com').fill("superma@gmail.com");
  await page.getByPlaceholder('password').fill("123");

  await page.getByRole('button', {name: 'Login'}).click();

  await page.getByRole("link", {name:"berikut"}).click();

  await page.getByRole("link", {name: "Ubah Password"}).click();

  await page.getByLabel("Password Lama").fill('123');
  
  await page.getByLabel("Password", { exact: true }).fill("1234");

  await page.getByLabel("Ulangi Password").fill("123");

  await page.getByRole("button", { name: "Ubah Password" }).click();

  await expect(page.getByText("The confirm password field must match password baru.")).toBeVisible({ timeout: 20000 });
  await expect(page.getByText("The confirm password field must match password baru.")).toHaveClass(/text-red-500/);
});