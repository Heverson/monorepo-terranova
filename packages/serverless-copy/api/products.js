"use strict";
const fetch = require('node-fetch');

module.exports.index = async (event) => {
  const {type} = event.pathParameters;
  const url = `${process.env.BASEURL}?action=products&type=${type}`;

  const fetchResult = await fetch(url)
  const products = await fetchResult.json();
  
  return {
    statusCode: 200,
    body: JSON.stringify(
      {
        products,
      },
      null,
      2
    ),
  };

  // Use this code if you don't use the http event with the LAMBDA-PROXY integration
  // return { message: 'Go Serverless v1.0! Your function executed successfully!', event };
};
