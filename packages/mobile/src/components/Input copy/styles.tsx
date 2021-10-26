import styled, {css} from 'styled-components/native';
import FeatherIcon from 'react-native-vector-icons/Feather';

interface ContainerProps {
  isFocused: boolean;
  isErrored: boolean;
}

export const Container = styled.View<ContainerProps>`
  width: 100%;
  height: 50px;
  padding: 0 16px;
  background: #fff;
  border-radius: 20px;
  margin-bottom: 8px;
  flex-direction: row;
  align-items: center;
  border-width: 1px;
  border-color: #e7e7e7;
  ${(props) =>
    props.isErrored &&
    css`
      border-color: #c53030;
    `}
  ${(props) =>
    props.isFocused &&
    css`
      border-color: #fcd85b;
    `}
`;

export const TextInput = styled.TextInput`
  flex: 1;
  color: #6c6c6c;
  font-size: 16px;
`;

export const Icon = styled(FeatherIcon)`
  margin-right: 16px;
`;
