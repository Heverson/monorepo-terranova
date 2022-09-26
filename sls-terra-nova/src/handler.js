"use strict";
const fetch = require('node-fetch');

module.exports.hello = async (event) => {
  return {
    statusCode: 200,
    body: JSON.stringify(
      {
        message: "Go Serverless v2.0! Your function executed successfully!",
        input: event,
      },
      null,
      2
    ),
  };
};

module.exports.getCheckout = async (event) => {
  const token = 'StN0x';
  const { checkoutParams } = JSON.parse(event.body);
  const { cart } = checkoutParams;
  
  return {
    statusCode: 200,
    body: JSON.stringify(
      {
        message: cart,
        input: token
      },
      null,
      2
    ),
  }
};