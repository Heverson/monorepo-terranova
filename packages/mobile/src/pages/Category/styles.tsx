import styled from 'styled-components/native';

export const Container = styled.View`
  background: #652650;
  padding:16px 16px;
  flex:1;
`;

export const NavLi = styled.View`
  padding: 15px 10px;
  flex-direction: row;
  justify-content: space-between;
`;
export const NavLiText = styled.Text`
  color: #fff;
  font-weight: bold;
  font-size: 16px;
  flex: 1;
  flex-wrap: wrap;
`;
export const NavLiChild = styled.View`
  padding: 15px 10px;
  flex-direction: row;
  justify-content: space-between;
`;
export const NavLiChildText = styled.Text`
  color: #fff;
  font-size: 14px;
  flex-wrap: wrap;
  padding-left: 10px;
`;
export const NavLineSeparator = styled.View`
  height: 1px;
  width: 100%;
  background-color: #e5e5e5;
`;
export const HeaderCategoryList = styled.View`
  flex-direction: column;
  padding-top: 20px;
  padding-bottom: 20px;
`;
export const HeaderCategoryTitle = styled.View`
  flex-direction: row;
  align-items: center;
`;
export const HeaderCategoryTitleText = styled.Text`
  font-size: 24px;
  font-weight: bold;
  color: #FFF;
  font-family: 'Rosario_400Regular';
`;
export const HeaderCategoryDescription = styled.Text`
  font-size: 16px;
  color: #FFF;
  line-height: 24px;
  padding: 10px 0;
`;
export const HeaderCategoryBackButton = styled.View`
  padding-right: 10px;
`;
