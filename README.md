# NodalFlow

[![Build Status](https://travis-ci.org/fab2s/NodalFlow.svg?branch=master)](https://travis-ci.org/fab2s/NodalFlow) [![License](https://poser.pugx.org/fab2s/nodalflow/license)](https://packagist.org/packages/fab2s/nodalflow)

NodalFlow is a generic Workflow that can execute chained tasks. It is designed arround simple interfaces that specifies a flow composed of executable nodes and flows. Nodes can be executed or traversed. They accept a single parameter as argument and can be set to pass their result as an argument for the next node.
Flows also accept one argument and may be set to pass their result to be used as an argument for the next node.

NodalFlow aims at organising and simplifying data processing workflows where data may come from various generators, pass through several data processors and / or end up in various places. It makes it possible to progaramatically configure and execute complex scenario in a repeatable manner.

[YaEtl](https://github.com/fab2s/YaEtl) is build upon [NodalFlow](https://github.com/fab2s/NodalFlow).
