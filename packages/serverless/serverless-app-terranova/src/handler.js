"use strict";
const fetch = require("node-fetch");

const getInfo = async (event) => {
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

const getBanners = async (event) => {
  const result = await fetch(
    "https://www.shoppingterranova.com.py/api/?action=banners"
  );
  const data = await result.json();

  return {
    statusCode: 200,
    body: JSON.stringify(
      {
        result: data,
      },
      null,
      2
    ),
  };
};

const getBrands = async (event) => {
  const result = await fetch(
    "https://www.shoppingterranova.com.py/api/?action=brands"
  );
  const data = await result.json();

  return {
    statusCode: 200,
    body: JSON.stringify(
      {
        result: data,
      },
      null,
      2
    ),
  };
};

const getCategories = async (event) => {
  const result = await fetch(
    "https://www.shoppingterranova.com.py/api/?action=categories"
  );
  const data = await result.json();

  return {
    statusCode: 200,
    body: JSON.stringify(
      {
        result: data,
      },
      null,
      2
    ),
  };
};

const getCategoryProducts = async (event) => {
  const { type } = event.pathParameters;
  const result = await fetch(
    `https://www.shoppingterranova.com.py/api/?action=products&type=${type}`
  );
  const data = await result.json();

  return {
    statusCode: 200,
    body: JSON.stringify(
      {
        result: data,
      },
      null,
      2
    ),
  };
};

const getProducts = async (event) => {
  const { type } = event.pathParameters;
  const result = await fetch(
    `https://www.shoppingterranova.com.py/api/?action=products&type=${type}`
  );
  const data = await result.json();

  return {
    statusCode: 200,
    body: JSON.stringify(
      {
        result: data,
      },
      null,
      2
      ),
    };
  };
  
  const createSession = async (event) => {
    const { username, password } = JSON.parse(event.body);
    const url = `https://www.shoppingterranova.com.py/api/?action=session&login=${username}&password=${password}`;
    const result = await fetch(url);
    const data = await result.json();
    
    return {
      statusCode: 200,
      body: JSON.stringify(
        {
          result: data,
        },
        null,
        2
        ),
      };
    };
    
  
 
  const checkoutCart = async (event) => {
    const token = 'StN0x';
    const { checkoutParams } = JSON.parse(event.body);
    const { cart } = checkoutParams;

    return {
      statusCode: 200,
      body: JSON.stringify(
        {
          result: 'teste Ok',
          json: cart
        },
        null,
        2
      ),
    }
  };


module.exports = {
  getInfo,
  getBanners,
  getBrands,
  getCategories,
  getCategoryProducts,
  getProducts,
  createSession,
  checkoutCart
};
