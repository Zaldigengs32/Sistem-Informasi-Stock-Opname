/**
 * Barlow Font for jsPDF
 * This file loads Barlow font and adds it to jsPDF
 * Using TTF format which is compatible with jsPDF
 */

// Global font family variable
var PDF_FONT_FAMILY = 'helvetica'; // default fallback

// Function to load font from URL and convert to Base64
async function loadBarlowFont(doc) {
  try {
    // Load Barlow Regular (TTF format from Google Fonts GitHub)
    const regularResponse = await fetch('https://raw.githubusercontent.com/jpt/barlow/master/fonts/ttf/Barlow-Regular.ttf');
    if (!regularResponse.ok) throw new Error('Failed to load regular font');
    const regularBuffer = await regularResponse.arrayBuffer();
    const regularBase64 = arrayBufferToBase64(regularBuffer);
    
    // Load Barlow Bold (TTF format)
    const boldResponse = await fetch('https://raw.githubusercontent.com/jpt/barlow/master/fonts/ttf/Barlow-Bold.ttf');
    if (!boldResponse.ok) throw new Error('Failed to load bold font');
    const boldBuffer = await boldResponse.arrayBuffer();
    const boldBase64 = arrayBufferToBase64(boldBuffer);
    
    // Load Barlow Italic (TTF format)
    const italicResponse = await fetch('https://raw.githubusercontent.com/jpt/barlow/master/fonts/ttf/Barlow-Italic.ttf');
    if (!italicResponse.ok) throw new Error('Failed to load italic font');
    const italicBuffer = await italicResponse.arrayBuffer();
    const italicBase64 = arrayBufferToBase64(italicBuffer);
    
    // Add fonts to jsPDF
    doc.addFileToVFS('Barlow-Regular.ttf', regularBase64);
    doc.addFileToVFS('Barlow-Bold.ttf', boldBase64);
    doc.addFileToVFS('Barlow-Italic.ttf', italicBase64);
    
    doc.addFont('Barlow-Regular.ttf', 'Barlow', 'normal');
    doc.addFont('Barlow-Bold.ttf', 'Barlow', 'bold');
    doc.addFont('Barlow-Italic.ttf', 'Barlow', 'italic');
    
    PDF_FONT_FAMILY = 'Barlow';
    return 'Barlow';
  } catch (error) {
    console.warn('Barlow font not available, using Helvetica fallback:', error.message);
    PDF_FONT_FAMILY = 'helvetica';
    return 'helvetica';
  }
}

// Helper function to convert ArrayBuffer to Base64
function arrayBufferToBase64(buffer) {
  let binary = '';
  const bytes = new Uint8Array(buffer);
  const len = bytes.byteLength;
  for (let i = 0; i < len; i++) {
    binary += String.fromCharCode(bytes[i]);
  }
  return btoa(binary);
}

// Initialize PDF with Barlow font - returns promise with font family name
async function initPDFWithBarlow(doc) {
  return await loadBarlowFont(doc);
}
