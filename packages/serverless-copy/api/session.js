"use strict";
const fetch = require('node-fetch');

module.exports.index = async (event) => {
  const { user, password } = JSON.parse(event.body);
  /**
   * SELECT * from usuarios
   * WHERE user = use_login OR user = use_email
   * AND MD5(password) = use_password
   */
  const url = `${process.env.BASEURL}?action=session&user=${user}&password=${password}`;

  const fetchResult = await fetch(url)
  const userAuthenticated = await fetchResult.json();

  return {
    statusCode: 200,
    body: JSON.stringify({ userAuthenticated }, null, 2),
  };

  // Use this code if you don't use the http event with the LAMBDA-PROXY integration
  // return { message: 'Go Serverless v1.0! Your function executed successfully!', event };
};
