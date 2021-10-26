'use strict';
const fetch = require('node-fetch');

module.exports.index = async (event) => {
  
  const url = `${process.env.BASEURL}?action=categories`;

  const fetchResult = await fetch(url)
  const categories = await fetchResult.json();

  return {
    statusCode: 200,
    body: JSON.stringify({ categories }, null, 2),
  };

  // Use this code if you don't use the http event with the LAMBDA-PROXY integration
  // return { message: 'Go Serverless v1.0! Your function executed successfully!', event };
};

module.exports.list = async (event) => {

  const {id}  = event.queryStringParameters;
  
  return {
    statusCode: 200,
    body: JSON.stringify(
      {
        products,
        id
      },
      null,
      2
    ),
  };
}