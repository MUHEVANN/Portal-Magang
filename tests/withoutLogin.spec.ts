import { test, expect } from '@playwright/test';

test('without login', async ({ page }) => { 
    await test.slow();
    await page.goto("http://127.0.0.1:8000/home");
    
    await expect(page.getByText("register")).toBeVisible({timeout: 10000});
    await expect(page.getByText("login")).toBeVisible({timeout: 10000});
  
    await expect(page.getByRole('button', {name: 'Lamar Magang'})).toBeDisabled();
    await expect(page.getByText("Hubungi Kita")).toBeVisible({timeout: 10000});
  
    // goto first job detail
    await page.getByTestId("lists").first().click();
    
    await expect(page.getByRole("heading", {name: "Jennings Boehm V"})).toBeVisible({timeout: 10000});
  
  
  
    await expect(page.getByText("Diskripsi")).toBeVisible({timeout: 10000});
    await expect(page.getByText("Keuntungan")).toBeVisible({timeout: 10000});
    await expect(page.getByText("Kualifikasi")).toBeVisible({timeout: 10000});
  
    await expect(page.getByRole("heading", {name: "3 November 2023"})).toBeVisible({timeout: 10000});
    await expect(page.getByRole("heading", {name: "15 November 2023"})).toBeVisible({timeout: 10000});
  
    // await expect(page.getByText("Jack Norman")).toBeVisible({timeout: 10000});
    // await page.locator('li').filter({ hasText: 'Jack Norman' }).locator('strong')
  
    // await expect(page.getByRole('img', { name: 'user profile' })).toBeVisible({timeout: 10000});
  
    await expect(page.getByRole("button",{name: "Lamar Magang"})).toBeDisabled();
  })