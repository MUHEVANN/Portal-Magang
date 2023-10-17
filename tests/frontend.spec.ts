import { test, expect } from '@playwright/test';

/*

@ts-check

*/

// test('has title', async ({ page }) => {
//   await page.goto('http://127.0.0.1:8000/login');

//   // Expect a title "to contain" a substring.
//   await expect(page.getByRole('heading',{name: 'Login'})).toBeVisible();
// });

// test('Forget Password Test', async ({ page }) => {
//   await page.goto('http://127.0.0.1:8000/login');

//   await page.getByRole("link", {name:'registrasi'}).click();
  
//   await expect(page.getByRole('heading',{name: 'Registrasi'})).toBeVisible();
//   await expect(page.getByRole('link',{name: 'login'}).first()).toBeVisible();

//   await page.goBack();
//   // Click the get started link.
//   await page.getByRole('link', { name: ' Lupa Password' }).click();

//   // Expects page to have a heading with the name of Installation.
//   await expect(page.getByRole('heading', { name: 'Lupa Password' })).toBeVisible();
// });


test("Home", async ({ page }) => {
  await page.goto("http://127.0.0.1:8000/home");

  await expect(page.getByRole("heading",{name: 'dapatkan kesempatan magang bersama jetorbit'})).toBeVisible();

  await expect(page.getByRole('link', {name: 'pelajari lebih lanjut'})).toBeVisible();

  await expect(page.getByRole('link', {name: "hubungi kita"})).toBeVisible();

  await page.getByRole('button',{name: 'urutkan berdasarkan'}).click();

  await expect(page.getByRole('radio', {name: "terbaru"})).toBeVisible();
  await expect(page.getByRole('radio', {name: "terlama"})).toBeVisible();

  await expect(page.getByRole('button', {name: 'lamar magang'})).toBeDisabled();

  await expect(page.getByRole('link', {name:'register'})).toBeVisible();
  await expect(page.getByRole('link', {name:'login'})).toBeVisible();

  await page.getByRole('button', {name: 'urutkan berdasarkan'}).click();
  
  await expect(page.getByTestId('lists')).toHaveCount(10);
  
  await expect(page.getByRole("list")).toHaveCount(3)
  
  await page.getByPlaceholder("E.g. java developer").fill("Deborah");
  await expect(page.getByTestId('lists')).toHaveCount(1);
  
  // await page.getByPlaceholder("E.g. java developer").clear()

  await page.getByText('5').click();
})