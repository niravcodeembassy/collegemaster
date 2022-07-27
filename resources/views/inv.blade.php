<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        /* Template Name: Professional  */

* {
    font-size: 14px;
    line-height: 21px;
}
:root {
  --primary-color: rgba(101, 57, 192, 1);
  --secondary-color: rgba(101, 57, 192, 0.1);
  --primary-background: rgba(101, 57, 192, 1);
  --secondary-background: rgba(101, 57, 192, 0.1);
  --title-font: 'Open Sans';
}
table {
    border-collapse: collapse;
}
.show-in-pdf {
  display: none;
}

.invoice-page .no-background {
  background: none;
}

.invoice-page {
  line-height: 21px;
  font-family: "Open Sans", Roboto, "Helvetica Neue", Helvetica, Arial, sans-serif;
}

@media print {
  .invoice-page {
    padding: 10px;
  }
}

.invoice-page .invoice-heading {
  font-family: -webkit-var(--title-font, 'Open Sans');
  font-family: var(--title-font, 'Open Sans');
  font-size: 32px;
  color: -webkit-var(--primary-color, rgba(101, 57, 192, 1));
  color: var(--primary-color, rgba(101, 57, 192, 1));
  display: -webkit-flex;
  display: flex;
  margin-bottom: 0;
}

.invoice-page .invoice-header {
  display: -webkit-flex;
  display: flex;
  justify-content: space-between;
  -webkit-justify-content: space-between;
  margin-top: 10px;
}

.invoice-page .invoice-head-table {
  overflow: hidden;
  border-radius: 2px;
  border-style: hidden;
  box-shadow: none;
  margin: auto 0 15px;
  border: none;
}

.invoice-page .invoice-head-table tbody th {
  text-align: left;
  vertical-align: top;
  color: rgba(0, 0, 0, 0.50);
}

.invoice-page .invoice-head-table th {
  padding: 5px 15px 5px 0;
  border: none;
}

.invoice-page .invoice-head-table td {
  padding: 5px 15px 5px 0;
  font-weight: bold;
  border: none;
}

.invoice-page .address-section-wrapper {
  display: -webkit-flex;
  display: flex;
  margin-bottom: 10px;
}

.invoice-page .shipped-section-wrapper {
  display: -webkit-flex;
  display: flex;
  margin-bottom: 10px;
}

.invoice-page .cos-section-wrapper {
  display: -webkit-flex;
  display: flex;
}

.invoice-page .address-section-billed-by {
  -webkit-flex: 1;
  flex: 1;
  text-align: left;
  background: -webkit-var(--secondary-background, rgba(101, 57, 192, 0.1));
  background: var(--secondary-background, rgba(101, 57, 192, 0.1));
  padding: 15px;
  -webkit-print-color-adjust: exact;
  color-adjust: exact;
  margin-top: 10px;
  margin-right: 5px;
  border-radius: 6px;
}

.invoice-page .address-section-billed-to {
  -webkit-flex: 1;
  flex: 1;
  text-align: left;
  background: -webkit-var(--secondary-background, rgba(101, 57, 192, 0.1));
  background: var(--secondary-background, rgba(101, 57, 192, 0.1));
  padding: 15px;
  -webkit-print-color-adjust: exact;
  color-adjust: exact;
  margin-top: 10px;
  margin-left: 5px;
  border-radius: 6px;
}

.invoice-page .address-section-shipped-to {
  -webkit-flex: 1;
  flex: 1;
  text-align: left;
  background: -webkit-var(--secondary-background, rgba(101, 57, 192, 0.1));
  background: var(--secondary-background, rgba(101, 57, 192, 0.1));
  padding: 15px;
  -webkit-print-color-adjust: exact;
  color-adjust: exact;
  margin-top: 10px;
  border-radius: 6px;
  margin-right: 10px;
  max-width: 50%;
}

.invoice-page .address-section-transport {
  -webkit-flex: 1;
  flex: 1;
  text-align: left;
  background: -webkit-var(--secondary-background, rgba(101, 57, 192, 0.1));
  background: var(--secondary-background, rgba(101, 57, 192, 0.1));
  padding: 15px;
  -webkit-print-color-adjust: exact;
  color-adjust: exact;
  margin-top: 10px;
  border-radius: 6px;
  max-width: 50%;
}

.invoice-page .address-section-billed-by .billed-by-heading {
  line-height: 31px;
  margin-bottom: 0;
  font-family: -webkit-var(--title-font, 'Open Sans');
  font-family: var(--title-font, 'Open Sans');
}

.invoice-page .address-section-billed-to .billed-to-heading {
  line-height: 31px;
  margin-bottom: 0;
  font-family: -webkit-var(--title-font, 'Open Sans');
  font-family: var(--title-font, 'Open Sans');
}

.invoice-page .address-section-shipped-to .shipped-to-heading {
  line-height: 31px;
  margin-bottom: 0;
  font-family: -webkit-var(--title-font, 'Open Sans');
  font-family: var(--title-font, 'Open Sans');
}

.invoice-page .address-section-transport .transport-heading {
  line-height: 31px;
  margin-bottom: 0;
  font-family: -webkit-var(--title-font, 'Open Sans');
  font-family: var(--title-font, 'Open Sans');
}

.invoice-page .address-section-billed-by .billed-by-address {
  display: flex;
  display: -webkit-flex;
  flex-direction: column;
  -webkit-flex-direction: column;
}

.invoice-page .address-section-billed-to .billed-to-address {
  display: flex;
  display: -webkit-flex;
  flex-direction: column;
  -webkit-flex-direction: column;
}

.invoice-page .address-section-shipped-to .shipped-to-address {
  display: flex;
  display: -webkit-flex;
  flex-direction: column;
  -webkit-flex-direction: column;
}

.invoice-page .address-section-transport p {
  margin-bottom: 5px;
}

.invoice-page .cos-column {
  -webkit-flex: 1;
  flex: 1;
  text-align: left;
  -webkit-print-color-adjust: exact;
  color-adjust: exact;
  margin: 10px 0;
  text-align: center;
}

.invoice-page .cos-column:first-child {
  margin-right: 5px;
}

.invoice-page .cos-column:last-child {
  margin-left: 5px;
}

.invoice-page .primary-text {
  color: -webkit-var(--primary-color, rgba(101, 57, 192, 1));
  color: var(--primary-color, rgba(101, 57, 192, 1));
  margin-bottom: 0.5rem;
}

.invoice-page .logo-wrapper {
  text-align: center;
  margin: 0;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  display: -webkit-flex;
  -webkit-box-pack: end;
  -ms-flex-pack: end;
  justify-content: flex-end;
  -webkit-justify-content: flex-end;
  -webkit-box-align: start;
  -webkit-align-items: flex-start;
  -ms-flex-align: start;
  align-items: flex-start;
}

.invoice-page .logo-wrapper img {
  max-width: 240px;
  max-height: 120px;
  -o-object-fit: scale-down;
  object-fit: scale-down;
}

.invoice-page .logo-wrapper.signature {
  display: flex;
  display: -webkit-flex;
  flex-direction: column;
  -webkit-flex-direction: column;
  align-items: center;
  -webkit-align-items: center;
}

.invoice-page .invoice-total-in-words-wrapper {
  flex: 1;
  -webkit-flex: 1;
}

.invoice-page .invoice-total-in-words {
  text-transform: uppercase;
}

.invoice-page .invoice-bank-and-logo-wrapper {
  display: flex;
  display: -webkit-flex;
  flex-direction: row;
  justify-content: space-between;
  -webkit-flex-direction: row;
  -webkit-justify-content: space-between;
  margin-top: 10px;
}

.invoice-page .link-button {
  background: none;
  cursor: pointer;
}

.invoice-page .invoice-bank-table {
  border: none;
}

.invoice-page .invoice-bank-table th {
  padding: 0 15px 0 0;
  border: none;
}

.invoice-page .invoice-bank-table td {
  border: none;
  padding: 0;
}

.invoice-page .invoice-terms {
  list-style: decimal !important;
  padding-left: 25px;
}

.invoice-page .invoice-payment-table {
  border: none;
}

.invoice-page .invoice-payment-table td {
  padding: 0 15px 5px 0;
  border: none;
}

.invoice-page .invoice-payment-table th {
  padding: 0 15px 5px 0;
  border: none;
}

.invoice-page .invoice-bank-upi-wrapper {
  display: flex;
  display: -webkit-flex;
}

.invoice-page .invoice-tag {
  display: inline-block;
  color: rgb(255, 255, 255);
  font-size: 12px;
  white-space: nowrap;
  margin-right: 8px;
  font-weight: 500;
  padding: 0px 5px;
  border-radius: 3px;
}

.invoice-page .invoice-tag.success {
  background: #52c41a;
}

.invoice-page .invoice-tag.warning {
  background: #faad14;
}

.invoice-page .invoice-tag.danger {
  background: #EA453D;
}

.invoice-page .invoice-tag.info {
  background: #2db7f5;
}

.invoice-page .invoice-tag.devider {
  background: #e8e8e8;
}

.invoice-page .secondary-button {
  align-items: center;
  background: -webkit-var(--primary-background, rgb(254, 62, 130));
  background: var(--primary-background, rgb(254, 62, 130));
  border-bottom-left-radius: 4px;
  border-bottom-right-radius: 4px;
  color: rgb(255, 255, 255);
  cursor: pointer;
  display: inline-flex;
  font-size: 15px;
  font-weight: 500;
  height: 35px;
  justify-content: center;
  letter-spacing: normal;
  line-height: 19.5px;
  margin-bottom: 2px;
  margin-left: 2px;
  margin-right: 2px;
  margin-top: 2px;
  padding-bottom: 8px;
  padding-left: 16px;
  padding-right: 16px;
  padding-top: 8px;
  text-align: center;
  text-decoration: none;
}

.invoice-page .pay-button-wrapper {
  text-align: center;
}

.invoice-page .pay-button-wrapper>small {
  color: rgba(0, 0, 0, 0.50);
}

.invoice-page .total-wrapper {
  display: flex;
  display: -webkit-flex;
  margin-top: 10px;
}

.invoice-page .invoice-bank-wrapper {
  display: -webkit-flex;
  display: flex;
  flex-direction: column;
  -webkit-flex-direction: column;
  padding: 10px 20px 0 20px;
  border-radius: 6px;
  margin-right: 12px;
  background-color: var(--secondary-background, rgba(101, 57, 192, 0.1));
  -webkit-print-color-adjust: exact;
}

.invoice-page .invoice-upi-wrapper {
  display: -webkit-flex;
  display: flex;
  flex-direction: column;
  -webkit-flex-direction: column;
  margin-left: 20px;
  text-align: center;
}

.invoice-page .invoice-upi-wrapper>button {
  background: none;
}

.invoice-page .invoice-upi-wrapper .upi-heading {
  font-weight: 500;
  font-size: 16.38px;
  font-family: -webkit-var(--title-font, 'Open Sans');
  font-family: var(--title-font, 'Open Sans');
}

.invoice-page .invoice-bank-wrapper .bank-heading {
  font-weight: 500;
  font-size: 16.38px;
  font-family: -webkit-var(--title-font, 'Open Sans');
  font-family: var(--title-font, 'Open Sans');
}

.invoice-page .qr-wrapper {
  display: -webkit-flex;
  display: flex;
  flex-direction: column;
  -webkit-flex-direction: column;
}

.invoice-page .qr-wrapper>img {
  margin: 0 auto;
}

.invoice-page .qr-wrapper>span {
  font-size: 10px;
}

.invoice-page .invoice-table {
  overflow: hidden;
  border-radius: 2px;
  border-style: hidden;
  box-shadow: none;
  margin-bottom: 10px;
}

.invoice-page.invoice-table tbody th {
  text-align: left;
  vertical-align: top;
}

.invoice-page .invoice-items-table {
  border: 0;
  box-shadow: none;
  overflow: hidden;
  border-style: hidden;
  margin: 0 0 10px;
  width: 100%;
  border-radius: 6px;
  border-color: -webkit-var(--primary-color, rgba(101, 57, 192, 1));
  border-color: var(--primary-color, rgba(101, 57, 192, 1));
  -webkit-print-color-adjust: exact;
  color-adjust: exact;
  box-shadow: 0 0 0 1px rgba(101, 57, 192, 0.1);
}

.invoice-page .invoice-items-table th {
  color: #fff;
  text-shadow: 0 0 #fff;
  background: -webkit-var(--primary-background, rgba(101, 57, 192, 1));
  background: var(--primary-background, rgba(101, 57, 192, 1));
  padding: 5px 5px 5px 10px;
  border: 0;
  border-color: -webkit-var(--primary-color, rgba(101, 57, 192, 1));
  border-color: var(--primary-color, rgba(101, 57, 192, 1));
  text-align: center;
  font-family: -webkit-var(--title-font, 'Open Sans');
  font-family: var(--title-font, 'Open Sans');
}

.invoice-page .invoice-items-table td {
  padding: 10px;
  border: 0;
  background: -webkit-var(--secondary-background, rgba(101, 57, 192, 0.1));
  background: var(--secondary-background, rgba(101, 57, 192, 0.1));
  vertical-align: middle;
  text-align: center;
  white-space: nowrap;
}

.invoice-page .invoice-items-table td:first-child {
  padding-left: 10px;
}

.invoice-page .invoice-items-table td:nth-child(2) {
  white-space: normal;
}

.invoice-page .invoice-items-table input, .invoice-page .invoice-items-table textarea {
  padding: 4px 0;
  font-size: 14px;
  line-height: 20px;
  min-height: 40px;
}

.invoice-page .custom-column {
  white-space: normal !important;
}

.invoice-page .invoice-totals-table {
  width: 100%;
  border: none;
}

.invoice-page .invoice-extra-total-table {
  width: 100%;
  border: none;
}

.invoice-page .invoice-extra-total-table td, .invoice-page .invoice-extra-total-table th {
  padding: 2px 15px;
  border: none;
}

.invoice-page .invoice-extra-total-table td:last-child, .invoice-page .invoice-extra-total-table th:last-child {
  text-align: right;
}

.invoice-page .invoice-totals-table tr:last-child th, .invoice-page .invoice-totals-table tr:last-child td {
  border-top: solid 1px black;
}

.invoice-page .invoice-totals-table td, .invoice-page .invoice-totals-table th {
  padding: 2px 15px;
  border: none;
}

.invoice-page .invoice-totals-table td:last-child, .invoice-page .invoice-totals-table th:last-child {
  text-align: right;
}

.invoice-page .item-name-row {
  display: none;
}

.invoice-page .hide-background>td {
  background: none;
}

.invoice-page .item-name-row.full-width {
  display: table-row !important;
}

.invoice-page .item-name-row>td {
  text-align: left !important;
  white-space: normal;
  padding-bottom: 0;
}

.invoice-page .small-item-row {
  display: none;
}

.invoice-page .small-item-row td:first-child {
  width: auto;
}

.invoice-page .large-item-row th:first-child, .invoice-page .large-item-row th:nth-child(2) {
  text-align: left;
}

.invoice-page .large-item-row td:first-child, .invoice-page .large-item-row td:nth-child(2) {
  text-align: left;
}

.invoice-page .large-item-row.gst-invoice td:first-child, .invoice-page .large-item-row.gst-invoice th:first-child, .invoice-page .large-item-row.gst-invoice td:nth-child(2), .invoice-page .large-item-row.gst-invoice th:nth-child(2) {
  display: table-cell;
}

.invoice-page .large-item-row.full-width td:first-child, .invoice-page .large-item-row.full-width th:first-child, .invoice-page .large-item-row.full-width td:nth-child(2), .invoice-page .large-item-row.full-width th:nth-child(2) {
  display: none !important;
}

.invoice-page .large-item-row.description td {
  white-space: pre-wrap;
  text-align: left;
}

.invoice-page .large-item-row.description div {
  max-width: 75%;
}


.invoice-page .early-pay-wrapper {
  background-image: url('/public/images/invoice/earlypay/bannerbg.png');
  margin: -10px -10px 20px -10px;
  padding: 32px;
  color: #fff;
}

.invoice-page .early-pay-wrapper p {
  margin-top: 8px;
}

.invoice-page .center-align-text {
  text-align: center;
}

.invoice-page .early-pay-heading {
  display: inline-flex;
}

.invoice-page .early-pay-heading svg {
  width: 48px;
  height: 48px;
  margin-left: -5px;
}

.invoice-page .early-pay-heading>div {
  display: flex;
  align-items: center;
  text-align: left;
}

.invoice-page .early-pay-heading>div>strong {
  display: inline-block;
  padding-left: 5px;
  font-size: 22px;
  font-weight: 600;
}

.invoice-page .large-text {
  font-size: 16px;
  display: inline-block;
  margin-bottom: 4px;
}

.invoice-page .large-text>span {
  font-size: 22px;
}

.invoice-page .small-text {
  font-size: 14px;
  opacity: 0.7;
  display: inline-block;
  margin-bottom: 4px;
}

.invoice-page .invoice-status {
  display: flex;
}

.invoice-page .invoice-status>span {
  padding: 0 5px !important;
  font-size: 12px !important;
  margin-right: 8px !important;
  font-weight: 500 !important;
}

.invoice-page .responsive-image {
  max-width: 100%;
  max-height: 100%;
  height: auto;
}

.invoice-page .page-footer {
  width: 100%;
  text-align: center;
  font-size: 10px;
}

.invoice-page .attachment-link {
  text-align: left;
  margin-bottom: 4px;
  background: none;
}

.invoice-page .bank-total-wrapper {
  display: -webkit-flex;
  display: flex;
  justify-content: space-between;
  -webkit-justify-content: space-between;
  page-break-inside: avoid;
}

.invoice-page .bank-total-wrapper .bank-words-wrapper {
  display: -webkit-flex;
  display: flex;
  flex-direction: column;
  -webkit-flex-direction: column;
}

.invoice-page .bank-total-wrapper .total-signature-wrapper {
  display: -webkit-flex;
  display: flex;
  flex-direction: column;
  -webkit-flex-direction: column;
}

.invoice-page .bank-total-wrapper .bank-words-wrapper .invoice-total-in-words-wrapper {
  margin-bottom: 30px;
  font-weight: 600;
}

.invoice-page .attachment-wrapper {
  margin-top: 20px;
}

.invoice-page .invoice-notes-wrapper {
  margin-top: 20px;
}

.invoice-page .invoice-notes-wrapper p {
  white-space: pre-line;
  -webkit-white-space: pre-line;
  orphans: 3;
  widows: 3;
}

.invoice-page .invoice-terms-wrapper {
  margin-top: 20px;
}

.invoice-page .invoice-payments-wrapper {
  margin-top: 20px;
}

.invoice-page .terms-heading {
  margin-bottom: 0.2rem;
  font-size: 16.38px;
  font-family: -webkit-var(--title-font, 'Open Sans');
  font-family: var(--title-font, 'Open Sans');
  page-break-inside: avoid;
}

.invoice-page .terms-heading::after {
  content: '';
  display: block;
  height: 80px;
  margin-bottom: -80px;
}

.invoice-page .invoice-terms>li {
  page-break-inside: avoid;
}

.invoice-page .payments-heading {
  margin-bottom: 0.2rem;
  font-size: 16.38px;
  font-family: -webkit-var(--title-font, 'Open Sans');
  font-family: var(--title-font, 'Open Sans');
  page-break-inside: avoid;
}

.invoice-page .payments-heading::after {
  content: '';
  display: block;
  height: 80px;
  margin-bottom: -80px;
}

.invoice-page .notes-heading {
  margin-bottom: 0.2rem;
  font-size: 16.38px;
  font-family: -webkit-var(--title-font, 'Open Sans');
  font-family: var(--title-font, 'Open Sans');
  page-break-inside: avoid;
}

.invoice-page .notes-heading::after {
  content: '';
  display: block;
  height: 80px;
  margin-bottom: -80px;
}

.invoice-page .attachment-heading {
  margin-bottom: 0.2rem;
  font-size: 16.38px;
  font-family: -webkit-var(--title-font, 'Open Sans');
  font-family: var(--title-font, 'Open Sans');
}

.invoice-page .attachment-link-wrapper {
  display: -webkit-flex;
  display: flex;
  flex-direction: column;
  -webkit-flex-direction: column;
}

.invoice-page .invoice-contact-wrapper {
  text-align: center;
  margin-top: 20px;
}

.invoice-page .address-section-transport .extra {
  margin-top: 10px;
}

.invoice-page .link {
  background: none;
}

/* Media Query */

@media print {
  .no-pdf {
    display: none;
  }
  .show-in-pdf {
    display: block !important;
  }
  .invoice-page .early-pay-wrapper {
    display: none;
  }
  .invoice-page .invoice-bank-wrapper {
    margin-top: 10px;
    padding: 10px 20px 0 20px;
    border-radius: 6px;
    margin-right: 12px;
    -webkit-print-color-adjust: exact;
    color-adjust: exact;
    background-color: var(--secondary-background, rgba(101, 57, 192, 0.1));
  }
  .invoice-page .invoice-bank-wrapper .bank-heading>button {
    display: none;
  }
  .invoice-page .invoice-upi-wrapper .upi-heading>button {
    display: none;
  }
}

@media screen and (max-width: 768px) {
  .invoice-page .invoice-bank-upi-wrapper {
    flex-direction: column;
    align-items: flex-start;
  }
}

@media screen and (max-width: 568px) {
  .invoice-page .invoice-header {
    flex-direction: column-reverse;
  }
  .invoice-page .logo-wrapper {
    margin: 0 auto;
  }
  .invoice-page .address-section-wrapper {
    flex-direction: column;
  }
  .invoice-page .shipped-section-wrapper {
    flex-direction: column;
  }
  .invoice-page .invoice-bank-and-logo-wrapper {
    flex-direction: column-reverse;
    justify-content: space-between;
  }
  .invoice-page .item-name-row>td {
    padding-bottom: 10px;
  }
  .invoice-page .small-item-row {
    display: table-row;
  }
  .invoice-page .small-item-row.full-width td {
    padding-top: 0;
  }
  .invoice-page .small-item-row.full-width td:first-child {
    font-weight: 600;
  }
  .invoice-page .invoice-items-table td {
    text-align: left;
  }
  .invoice-page .invoice-items-table th {
    text-align: left;
  }
  .invoice-page .large-item-row {
    display: none;
  }
  .invoice-page .large-item-row.gst-invoice td:first-child, .invoice-page .large-item-row.gst-invoice th:first-child, .invoice-page .large-item-row.gst-invoice td:nth-child(2), .invoice-page .large-item-row.gst-invoice th:nth-child(2) {
    display: none;
  }
  .invoice-page .early-pay-heading>div>strong {
    font-size: 28px;
  }
  .invoice-page .invoice-bank-table th {
    padding-right: 10px;
  }
  .invoice-page .invoice-head-table {
    width: 100%;
  }
  .invoice-page .invoice-head-table th {
    padding-right: 0;
  }
  .invoice-page .invoice-header .logo-wrapper {
    margin-top: 0;
  }
  .invoice-page .bank-total-wrapper {
    flex-direction: column-reverse;
  }
  .invoice-page .invoice-bank-wrapper {
    margin-top: 10px;
    padding: 10px 20px 0 20px;
    border-radius: 6px;
    -webkit-print-color-adjust: exact;
    background-color: var(--secondary-background, rgba(101, 57, 192, 0.1));
  }
  .invoice-page .invoice-bank-upi-wrapper {
    flex-direction: column;
  }
  .invoice-page .invoice-upi-wrapper {
    margin-left: 0;
    margin-top: 10px;
    text-align: left;
  }
  .invoice-page .qr-wrapper>img {
    margin: 0;
  }
  .invoice-page .invoice-upi-wrapper>button {
    text-align: left;
    padding-left: 10px;
  }
  .invoice-page .logo-wrapper img {
    max-width: 180px;
  }
  .invoice-page .item-name-row {
    display: table-row;
  }
  .invoice-page .address-section-billed-by {
    margin-right: 0;
  }
  .invoice-page .address-section-billed-to {
    margin-left: 0;
  }
  .invoice-page .address-section-shipped-to {
    margin-right: 0;
    max-width: 100%;
  }
  .invoice-page .address-section-transport {
    max-width: 100%;
  }
  .invoice-page .invoice-payment-table-scroll {
    overflow-x: auto;
    padding: 0;
  }
}

@media screen and (max-width: 992px) {
  .invoice-page .invoice-items-table-wrapper {
    overflow-x: auto;
    padding: 0 1px;
  }
  .invoice-page .item-name-row.gst-invoice {
    display: table-row;
  }
  .invoice-page .large-item-row.gst-invoice td:first-child, .invoice-page .large-item-row.gst-invoice th:first-child, .invoice-page .large-item-row.gst-invoice td:nth-child(2), .invoice-page .large-item-row.gst-invoice th:nth-child(2) {
    display: none;
  }
}

@media screen and (max-width: 768px) {
  .invoice-page .large-item-row.gst-invoice td:first-child, .invoice-page .large-item-row.gst-invoice th:first-child, .invoice-page .large-item-row.gst-invoice td:nth-child(2), .invoice-page .large-item-row.gst-invoice th:nth-child(2) {
    display: none;
  }
}

@media screen and (min-width: 992px) and (max-width: 1200px) {
  .invoice-page .item-name-row.aside-collpased {
    display: none;
  }
  .invoice-page .large-item-row.aside-collpased td:first-child, .invoice-page .large-item-row.aside-collpased th:first-child, .invoice-page .large-item-row.aside-collpased td:nth-child(2), .invoice-page .large-item-row.aside-collpased th:nth-child(2) {
    display: table-cell;
  }
}

@media (min-width: 768px) {
  .invoice-page .early-pay-wrapper {
    margin: -48px -48px 20px -48px;
  }
}
    </style>
</head>

<body>
    <div class="invoice-page" id="invoice-page">
        <div>
            <div class="refrens-header-wrapper">
                <div class="invoice-heading"><span>Invoice&nbsp;</span>
                    <div class="invoice-status no-print"></div>
                </div>
                <div class="invoice-header">
                    <div class="invoice-detail-section">
                        <table border="0" class="invoice-table invoice-head-table">
                            <tbody>
                                <tr>
                                    <th>Invoice No#</th>
                                    <td>00001</td>
                                </tr>
                                <tr>
                                    <th>Invoice Date</th>
                                    <td>
                                        <div><span>November 07, 2020</span></div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Due Date</th>
                                    <td>November 22, 2020</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="address-section-wrapper">
                <div class="address-section-billed-by">
                    <h2 class="primary-text billed-by-heading">Billed By</h2><b>MMT</b>
                    <div class="billed-by-address"><span>Santkabir Road Rajkot ,,&nbsp;</span><span>Rajkot,&nbsp;</span>
                        <div class="billed-by-sub-address"><span>Andhra Pradesh
                                (28),&nbsp;</span><span>India&nbsp;</span><span>- 360003</span></div>
                    </div>
                    <div class="address-email"><b>Email: </b><span>admin@admin.com</span></div>
                </div>
                <div class="address-section-billed-to">
                    <h2 class="primary-text billed-to-heading">Billed To</h2><b>MMT</b>
                    <div class="billed-to-address"><span>Rivera Wave, 150 Feet Ring Road, Kalawad Road -
                            Rajkot,&nbsp;</span><span>Rajkot,&nbsp;</span>
                        <div class="billed-to-sub-address"><span>Andhra Pradesh
                                (28),&nbsp;</span><span>India&nbsp;</span><span>- 362011</span></div>
                    </div>
                    <div class="address-email"><b>Email: </b><span>makemytrip@gmail.com</span></div>
                </div>
            </div>
            <div class="shipped-section-wrapper"></div>
            <div class="cos-section-wrapper">
                <div class="cos-column"><span class="cos-column-title"><b>Country of Supply :
                        </b></span><span>India</span></div>
                <div class="cos-column"><span class="cos-column-title"><b>Place of Supply : </b></span><span>Andhra
                        Pradesh (28)</span></div>
            </div>
            <div class="invoice-items-table-wrapper">
                <table class="invoice-table invoice-items-table">
                    <thead>
                        <tr class="no-pdf small-item-row">
                            <th>Amount</th>
                            <th>Discount</th>
                            <th>GST</th>
                            <th>Total</th>
                        </tr>
                        <tr invoicetype="INVOICE" class="large-item-row gst-invoice">
                            <th width="10" class="lll"></th>
                            <th>Item</th>
                            <th>GST</th>
                            <th>Quantity</th>
                            <th>Rate</th>
                            <th>Discount</th>
                            <th>Amount</th>
                            <th>CGST</th>
                            <th>SGST</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="no-pdf item-name-row gst-invoice">
                            <td colspan="100"><b>1.</b> <span>Test</span><small> (HSN/SAC: 0)</small></td>
                        </tr>
                        <tr class="no-pdf item-name-row">
                            <td colspan="100">Test data </td>
                        </tr>
                        <tr class="no-pdf small-item-row">
                            <td>$1,00,000<small><br>(1 x $1,00,000)</small></td>
                            <td>5%</td>
                            <td>$17,100<small><br>(@ 18%)</small></td>
                            <td><b>$1,12,100</b></td>
                        </tr>
                        <tr class="large-item-row gst-invoice">
                            <td>1.</td>
                            <td class="">Test<small> (HSN/SAC: 0)</small></td>
                            <td class="" width="10">18%</td>
                            <td class="" width="10">1</td>
                            <td class="" width="10">$1,00,000</td>
                            <td class="" width="10">5%</td>
                            <td class="" width="10">$95,000</td>
                            <td class="" width="10">$8,550</td>
                            <td class="" width="10">$8,550</td>
                            <td class="" width="10">$1,12,100</td>
                        </tr>
                        <tr class="large-item-row description">
                            <td colspan="100">
                                <div>Test data </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="bank-total-wrapper">
                <div class="bank-words-wrapper">
                    <div class="invoice-total-in-words-wrapper">
                        <p><span class="invoice-total-in-words-title">Invoice total (in words) : </span><span
                                class="invoice-total-in-words">one lakh twelve thousand one hundred rupees only</span>
                        </p>
                    </div>
                    <div class="invoice-bank-upi-wrapper"></div>
                </div>
                <div class="total-signature-wrapper">
                    <div class="invoice-total-calculation">
                        <table border="0" class="invoice-table invoice-totals-table">
                            <tbody>
                                <tr>
                                    <th>Sub Total</th>
                                    <td>$1,00,000</td>
                                </tr>
                                <tr>
                                    <th>Discount(5%)</th>
                                    <td>($5,000)</td>
                                </tr>
                                <tr>
                                    <th>Amount</th>
                                    <td>$95,000</td>
                                </tr>
                                <tr>
                                    <th>SGST</th>
                                    <td>$8,550</td>
                                </tr>
                                <tr>
                                    <th>CGST</th>
                                    <td>$8,550</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>$1,12,100</td>
                                </tr>
                            </tbody>
                        </table>
                        <table border="0" class="invoice-table invoice-extra-total-table">
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="invoice-terms-wrapper">
                <div class="primary-text terms-heading">Terms and Conditions</div>
                <ol class="invoice-terms">
                    <li>Please pay within 15 days from the date of invoice, overdue interest @ 14% will be charged on
                        delayed payments.</li>
                    <li>Please quote invoice number when remitting funds.</li>
                </ol>
            </div>
        </div>
    </div>
    <input type="button" id="create_pdf" value="Generate PDF">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
   <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
   <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>


   <script>


        $(document).ready(function () {
                  var element = document.getElementById('invoice-page');
        var opt = {
            margin:       0.2,
            filename:     'myfilse.pdf',
            image:        { type: 'jpeg', quality: 1 },
            html2canvas:  { scale: 0,logging: false },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
        };
        // New Promise-based usage:
        html2pdf().from(element).set(opt).save();
        });

    // (function () {
    //     var
    //      form = $('.invoice-page'),
    //      cache_width = form.width(),
    //      a4 = [595.28, 841.89]; // for a4 size paper width and height

    //     $('#create_pdf').on('click', function () {
    //         $('body').scrollTop(0);
    //         createPDF();
    //     });
    //     //create pdf
    //     function createPDF() {
    //         getCanvas().then(function (canvas) {

    //             var
    //              img = canvas.toDataURL({
    //                 format: 'jpeg',
    //                 quality: 1
    //             }),
    //              doc = new jsPDF({
    //                  unit: 'px',
    //                  format: 'a4'
    //              });
    //             doc.addImage(img, 'JPEG', 20, 20);
    //             doc.save('Bhavdip-html-to-pdf.pdf');
    //         });
    //     }

    //     // create canvas object
    //     function getCanvas() {
    //         return html2canvas(form.get(0), {
    //             quality: 5,
    //             scale: 1
    //         });

    //         // form.width((a4[0] * 1.33333) - 80).css('max-width', 'none')
    //         // return html2canvas(form, {
    //         //     imageTimeout: 2000,
    //         //     removeContainer: true
    //         // });
    //     }

    // }());
</script>
<script>
    /*
 * jQuery helper plugin for examples and tests
 */
    // (function ($) {
    //     $.fn.html2canvas = function (options) {
    //         var date = new Date(),
    //         $message = null,
    //         timeoutTimer = false,
    //         timer = date.getTime();
    //         html2canvas.logging = options && options.logging;
    //         html2canvas.Preload(this[0], $.extend({
    //             complete: function (images) {
    //                 var queue = html2canvas.Parse(this[0], images, options),
    //                 $canvas = $(html2canvas.Renderer(queue, options)),
    //                 finishTime = new Date();

    //                 $canvas.css({ position: 'absolute', left: 0, top: 0 }).appendTo(document.body);
    //                 $canvas.siblings().toggle();

    //                 $(window).click(function () {
    //                     if (!$canvas.is(':visible')) {
    //                         $canvas.toggle().siblings().toggle();
    //                         throwMessage("Canvas Render visible");
    //                     } else {
    //                         $canvas.siblings().toggle();
    //                         $canvas.toggle();
    //                         throwMessage("Canvas Render hidden");
    //                     }
    //                 });
    //                 throwMessage('Screenshot created in ' + ((finishTime.getTime() - timer) / 1000) + " seconds<br />", 4000);
    //             }
    //         }, options));

    //         function throwMessage(msg, duration) {
    //             window.clearTimeout(timeoutTimer);
    //             timeoutTimer = window.setTimeout(function () {
    //                 $message.fadeOut(function () {
    //                     $message.remove();
    //                 });
    //             }, duration || 2000);
    //             if ($message)
    //                 $message.remove();
    //             $message = $('<div ></div>').html(msg).css({
    //                 margin: 0,
    //                 padding: 10,
    //                 background: "#000",
    //                 opacity: 0.7,
    //                 position: "fixed",
    //                 top: 10,
    //                 right: 10,
    //                 fontFamily: 'Tahoma',
    //                 color: '#fff',
    //                 fontSize: 12,
    //                 borderRadius: 12,
    //                 width: 'auto',
    //                 height: 'auto',
    //                 textAlign: 'center',
    //                 textDecoration: 'none'
    //             }).hide().fadeIn().appendTo('body');
    //         }
    //     };
    // })(jQuery);

</script>
</body>

</html>
