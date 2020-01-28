# `parser-interpreter`

A Pascal interpreter based on the ["Let's Build A Simple Interpreter"](https://ruslanspivak.com/lsbasi-part1/) series.

## Grammar

```
program : PROGRAM variable SEMI block DOT

block : declarations compound_statement

declarations : VAR (variable_declaration SEMI)+
              | empty

variable_declaration : ID (COMMA ID)* COLON type_spec

type_spec : INTEGER | REAL

compound_statement : BEGIN statement_list END

statement_list : statement
                | statement SEMI statement_list

statement : compound_statement
          | assignment_statement
          | empty

assignment_statement : variable ASSIGN expr

empty :

expr : term ((PLUS | MINUS) term)*

term : factor ((MUL | INTEGER_DIV | FLOAT_DIV) factor)*

factor : PLUS factor
        | MINUS factor
        | INTEGER_CONST
        | REAL_CONST
        | LPAREN expr RPAREN
        | variable

variable: ID
```

## License

This project is licensed under the MIT License. See [LICENSE](LICENSE) for details.
