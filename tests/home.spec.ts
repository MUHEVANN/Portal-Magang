import { test, expect } from '@playwright/test';

/*

@ts-check

*/

// test('has title', async ({ page }) => {
//   await page.goto('http://127.0.0.1:8000/login');

//   // Expect a title "to contain" a substring.
//   await expect(page.getByRole('heading',{name: 'Login'})).toBeVisible({timeout: 10000});
// });

// test('Forget Password Test', async ({ page }) => {
//   await page.goto('http://127.0.0.1:8000/login');

//   await page.getByRole("link", {name:'registrasi'}).click();
  
//   await expect(page.getByRole('heading',{name: 'Registrasi'})).toBeVisible({timeout: 10000});
//   await expect(page.getByRole('link',{name: 'login'}).first()).toBeVisible({timeout: 10000});

//   await page.goBack();
//   // Click the get started link.
//   await page.getByRole('link', { name: ' Lupa Password' }).click();

//   // Expects page to have a heading with the name of Installation.
//   await expect(page.getByRole('heading', { name: 'Lupa Password' })).toBeVisible({timeout: 10000});
// });


test("Home", async ({ page }) => {
  await test.slow();
  await page.goto("http://127.0.0.1:8000/home");

  await expect(page.getByRole("heading",{name: 'dapatkan kesempatan magang bersama jetorbit'})).toBeVisible({timeout: 10000});

  await expect(page.getByRole('link', {name: 'pelajari lebih lanjut'})).toBeVisible({timeout: 10000});

  await expect(page.getByRole('link', {name: "hubungi kita"})).toBeVisible({timeout: 10000});

  await page.getByRole('button',{name: 'Urutkan Berdasarkan'}).click();

  await expect(page.getByRole('radio', {name: 'Terlama'})).toBeVisible({timeout: 10000});
  await expect(page.getByRole('radio', {name: 'Terbaru'})).toBeVisible({timeout: 10000});

  await expect(page.getByRole('button', {name: 'lamar magang'})).toBeDisabled();

  await expect(page.getByRole('link', {name:'register'})).toBeVisible({timeout: 10000});
  await expect(page.getByRole('link', {name:'login'})).toBeVisible({timeout: 10000});

  await page.getByRole('button', {name: 'Urutkan Berdasarkan'}).click();
  
  await expect(page.getByTestId('lists')).toHaveCount(10);
  
  // await expect(page.getByRole("list")).toHaveCount(3)
  
  await page.getByPlaceholder("E.g. java developer").fill('Chloe');
  await expect(page.getByTestId('lists')).toHaveCount(10);
  
  await page.getByPlaceholder("E.g. java developer").clear()
  // await page.getByText('5').click();
})



