import { test, expect } from '@playwright/test';
import { elements } from 'chart.js';

test('registered to intern job and solo', async ({ page }) => {
    await test.slow();
  
    await page.goto("http://127.0.0.1:8000/login");
  
    await page.getByPlaceholder('e.g. fulan@email.com').fill("superma@gmail.com");
    await page.getByPlaceholder('password').fill("123");

    await page.getByRole('img', { name: 'eye-pass', exact: true }).click();
  
    await page.getByRole('button', {name: 'Login'}).click();

    await page.getByRole("link", { name: "Lamar Magang"}).click();

    await expect(page.getByText("Tanggal Magang")).toBeVisible();
    await expect(page.getByText("Peserta Magang")).toBeVisible();
    
    await expect(page.getByText("Tanggal Magang")).toHaveClass("font-bold");

    await expect(page.getByLabel("Tanggal Mulai")).toHaveAttribute("type","date");
    await expect(page.getByLabel("Tanggal Selesai")).toHaveAttribute("type","date");

    // await page.getByLabel("Tanggal Mulai").fill("11/25/2023");
    // await page.getByLabel("Tanggal Mulai").fill("01/28/2024");

    await page.getByRole("button",{ name: "Berikutnya"}).click();
    
    await expect(page.getByText("Tanggal tidak boleh kosong!")).toBeVisible();
    
    await page.getByLabel('Tanggal Mulai').fill("2023-11-24");
    await page.getByLabel('Tanggal Selesai').fill("2024-01-28");
    
    await page.getByRole("button",{ name: "Berikutnya"}).click();

    await expect(page.getByText("Peserta Magang")).toHaveClass("font-bold");

    await page.getByLabel("Job Ketua").selectOption({label: "Prof. Gloria Volkman V"});

    await page.getByRole("button", {name: "Kirim"}).click();
    
    await expect(page.getByText("CV ketua tidak sesuai, Mohon coba lagi!")).toBeVisible();

    await page.getByLabel("CV Ketua", { exact: true }).setInputFiles("public/assets/Surat Penerimaan Magang - Hanif Nanda Afrian.pdf");

    await expect(page.getByText("File sudah Valid")).toBeVisible();

    await page.getByLabel("Nomor WA").fill("087686794024");

    await page.getByRole("button", {name: "Kirim"}).click();
    
    await expect(page.getByText("Masukan Tipe Magang yang akan dijalankan!")).toBeVisible();
    // await page.
    
    await page.getByLabel("Tipe Magang", { exact: true }).selectOption({label: "Mandiri"});
    
    await page.getByRole("button", {name: "Kirim"}).click();

    await expect(page.getByText("Dapatkan kesempatan magang bersama Jetorbit")).toBeVisible({ timeout: 20000 });
  })
  
  // Anda sudah melakukan Apply, silahkan tunggu konfirmasi dari kami
