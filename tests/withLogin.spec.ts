import { test, expect } from '@playwright/test';

test('with login', async ({ page }) => { 
  await test.slow();
  await page.goto("http://127.0.0.1:8000/login");

  await page.getByPlaceholder('e.g. fulan@email.com').fill("superma@gmail.com");
  await page.getByPlaceholder('password').fill("123");

  await page.getByRole('button', {name: 'Login'}).click();

  await page.getByTestId('menus').first().click();

  await expect(page.getByRole('link', { name: 'person Profile' })).toBeVisible({timeout: 10000});
  await expect(page.getByRole('link', { name: 'dashboard Dashboard' })).toBeVisible({timeout: 10000});
  await expect(page.getByRole('link', { name: 'log out Logout' })).toBeVisible({timeout: 10000});
  
  await page.getByRole('link', { name: 'person Profile' }).click();
  
  await expect(page.getByRole("heading", {name: "Profilku"})).toBeVisible({timeout: 10000});

  await page.getByLabel("Name").clear();
  await page.getByLabel("Name").fill("Jack Norman");

  await page.getByRole("button", {name: "Perbarui"}).click();
  
  await page.getByText("Kembali").click();

  // await expect(page.getByRole("strong")).toBeVisible({timeout: 10000});

  await page.getByTestId("menus").first().click();
  
  await page.getByRole('link', { name: "dashboard Dashboard" }).click();
  
  await expect(page.getByText("Halo, Jack Norman")).toBeVisible({timeout: 10000});

  await page.getByText("Kembali").click();

  await expect(page.getByText("Akun anda belum terverifikasi, silahkan verifikasi dengan mengklik tautan")).toBeVisible({timeout: 10000});
  await expect(page.getByRole("button",{ name: "Lamar Magang"})).toBeDisabled();

  // await page.getByRole('button', {name: 'Lamar Magang'}).click();

  // Logout
  await page.getByTestId("menus").first().click();
  await page.getByRole("link", { name: "log out Logout" }).click();
})