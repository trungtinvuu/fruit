export class ValidationRules {

  static textRule() {
    return [
      v => !!(v || '').trim() || 'Field is required'
    ];
  }

  static priceRule() {
    return [
      v => !isNaN(parseFloat(v)) && isFinite(v) || 'Price must be a valid number',
      v => parseFloat(v) >= 0 || 'Price must be a positive number',
    ];
  }

}
