<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of testeConnectionFactory
 *
 * @author Renan
 */
include('includes.php');

class testeEmpresa extends PHPUnit_Framework_TestCase {

    public function testSimple() {

        $con = new ConnectionFactory();

        $empresa = Utilidades::getEmpresaTeste();

        $usuario = Utilidades::getUsuarioTeste($empresa);
        $usuario->login = "a";
        $usuario->merge($con);

        $rec = Utilidades::getReceituarioTeste($empresa);
        $rec = Utilidades::getReceituarioTeste($empresa);
        $rec = Utilidades::getReceituarioTeste($empresa);
        $rec = Utilidades::getReceituarioTeste($empresa);
        $produto = Utilidades::getProdutoTeste($empresa);
        $produto = Utilidades::getProdutoTeste($empresa);
        $produto = Utilidades::getProdutoTeste($empresa);
        $produto = Utilidades::getProdutoTeste($empresa);

        $logo = Utilidades::getLogoTeste($empresa);
        $logo->logo = "iVBORw0KGgoAAAANSUhEUgAAAUIAAAA8CAYAAAAT8rOZAAAuhUlEQVR42u1dd3RVxfZ+fz3h0pLQESOiICKIIqAPQaxRH/6sWECxIoQWLE+f7VlAxYKKLYKApvdASIEQSAhpJLSQAOmN0BUEAvh8CszvfHvOzJ1zbsm9EDS4zl7rrpty7zlzpnyzy7f3/O1vf4Iwxvy112zmnWThe3+zxBJLLDnfRQfBLIFup0+fZgvKF7IJayewEctGsMviLmNXxQ9g/1x1F3tvy2y2/XC5BYaWWGLJXxcEE+oT2cDEAcwvrD3rFNqO+YZ3YL6hbZmP9nvHMLzbWK+ILuyz0vkWGFpiiSV/GSAMEmi2qGIJAZ5PWBvWM6oreyx7PPu05HMWXxfHFpYtYlMLprJB8f00kLQRIL696W0VDIOs3rTEEkvOV22QZN2+dQRw0ATHpI5mJT/vcOkYnLV+BgFmp/A2LKY6Wv3XKO1ls3rWEkssOS+1wdtW3cZ8ItqxQYlXsJOnTzYbJXkud7JmMrdjQ5OHGf5++vTpGv26lqlsiSWWnBdASL7B9T/mM5/QjqQNhlaFGYBt/YEiNrdkLvtqx5es5lid/HvTb0dZn+he9J2vy75iv5363YooW2KJJeclEJJ8VPwRmcVdo7qwE7+fkEj25bavdRO4Pb3Db7hm7xr5//sz7tX+Z6P/9Y27iKLMGbszLDC0xBJLzj8gfG3TaxT86BnVnR389SD9reTgdvrbuDXj2M6mRrbpUDG7MmEAG7J0oES5bysWMf+YHgSEfrrPEKD51LpnLDC0xBJLzi8gfGPjGwR6PSK7sfrjDfS378q/I3ArOVzKTnHnHwsuX0ygV91ULVFuZ1Mte3PzG6xHdHfWObyd9upA17ptxS0WGFpiiSXnDxCCBgPw6h7RWYJcYkMSmcs/VIWyk4wHTybnTSGwA+HaIXiyboqk1XQKvYAoOE9nT1Q/EmD1uCWWWNJqgXD2ljkEYF3CfVjZkTI7FyZ5JAFaUP4LbELmRNY+7O9sVt4sAwAWHMhjI1NuYD4RHVi3cD923fLh7Jbk0dp3b2AjkoaxHfbrBfwBz+OvR6yD9VeLRq+V62d5kHrYaiPnzTxH1l8t6n+u58VfEBdEf4Xor1e114C/PBB+UPwhASHM2m2Htxkiw49nj9dM5s7skhh/9sbmNw0rBpHi/rF9SRPsHdObQNGNBPwBg+dsYQf9QeDXLCi2wLUgR/TJeZ/26nKOnyPrT9xMWqR9buaFS3fN2fZVCz/jb9orVXtNctZeL+91xv2lWYGlrQYM1YfWGrb3bCeqeEhkj/joZOqtP5d4PEKrdq0in2GXiI4sqj76rBaT/mwY7FSdi+jxs5kHL3PvKrb+wHq1Df5n0dcOUneslmXtz2SLKheyj4vnUv71p9s/YRG14Sz3wDpWc7Ta2deCXF3vLCTEw351et/ypjK2Zt9KFl0bwcJrQljyziS24eAmV/dqEUA8B33gdrNT71f8UzFb2pjQ7PfOso1B5+gZIROctDXgXPUX4gVLd8arrrBXWwsQTmjJ3Vt88esdwToQ2thG40KI03ck8z1IVu5Kp+/0ib7IvHP4t6B2EODN4noq72l6ljGpo85YK3S2Kxb9WMheKprFhiVdw9MQIzqwjmHt9JTE9kQjElSiHlG+7MqlV7CHMh9iqTtT1L4Lpo1n2+fs4uherF/8JfS5KxP6syGJV7LBSweyqxKvYAMS+rA+MRfSZwbGXsqGLhvExqSPYU9mP62B7wIDxckDzcbwHGv3ZbHJec+ywQkDWKfQtswvtCNxSEXb8XO/2AvZA5n3sNi6+Bbnhoo+uH3lreziqN5aH/Tjz730UjZY64NBiZdTn1wW15ddGnsxuyS2N736ahZJv/hLKQ8epH+8Xtgohz3LzfOThNVHyNz5nXpA0M33qI0vFD5PtLDL4/qxa5OuZNeincuuoPEYvLS/9vOVNIb9Yy5i83d8Kq4pzG+trzNZn9g+mtXUhw1KGMSGLBvMrkkaxK7WroFxxvPcnDKKJTUupWe8LK4PuzoRfaF9Vvvc0GUDKegomBz6WvR3BoS1x+vZQO16/WK19ib2Y0OXDqb74DqDEgZqfXkJuyV1tGyjm/HJ4iBYx/rE9SYrcXHVwrNSKs4FENLI5/yYzdY1ZlNjz1IL4xHiyiU6BcbGCg8UyYs097303atocl0c21PdNSadDfjtO7afpe9JYxv3FXkDhHSthqZ61j2qM2m2XSM7sYqmCrcT3hPw2PBTEXto3b08/VAHjNvTbmLfVMxnWw5uJu0Q98ncs5q9UvQiuQoE7xKvR7MeVB+PFkjO/mz2fOFMNjJpuPwcQFWA0UXRPdnEnEfZ1NzJ7Jb0m/TP8PvjZ9xjcfl3bgHK/Bzbjm7X2jJO8kJxrcn5k9jqPRms9OdSes7Pt89jw5Zfxd0kIR3pPWDFzVp7c1oMDEUffL19PpuU+wzrqwEAwLdjhE3SsOCXvjrhSnZ3xj/Z3WvuYmNX38nuSLudFjf+JzbtsavucjtX1Q0SY4bv+YZ1YgvLg90ubNHG1J3LtXGawYYlD+P0sLCOShv5eIxZcYM27v9ieT/mOQBh9Ylq9tamN9i4zHsJUDqH8r7HOOMa49c+xL4p/5JVHa5kr236NwtIv8V4fX1N3rHqVpf9r2qEH22dyyblT9aA8FK5OeO9e6QPeyrnCfaVdi93QKhuHB+Wfsjb8kMHdmf67a2rpoAY2F9P/sqmF0xm0/Omszlb32ZxtdFsx+EdXoOi+EBUdZTW4W2o43P2Gfx8Tp3MdiDMoMo0WLi/nZKK4zxvwQ8LEebZO1v+w6bnB7KZ+dM81gjV9nywdTbt+EKzwe/e7GRm8PigdA4FgMTC6xHZhX1fuditzYEN4dHMh/lE1DYJLGaT2WSQ65NH2EnrOtAu1LQ+VdbtzWX9E/rKXHACMhS9MPpsg1w9R0J9vDZG3fWFbCN/77oDOS6fYUbBVJlp5Eeuj/bagv26RcDQ3AebftxIm5dPmE1uCnhtOrzB+WTem0kaD9I7b0u9sTkgzOL3KCIgEv1224qb3C5sZ+M0fNk1dE8/2UYbu2fV3R6bxnl717KeMV05uIT7sOUNy5w+36KKRXrf2+QY4P2x7Ied9r8rn94/UoYzv5ALaD5F10R7ZBqr7b5a03Z55al2rFukH6ttqvNaqTiXQBhgn9yxVA1mev5UNi1vCgtcP5m9tuFVFl4TQcDiQuaphRHkteoSaGA7hl2gqfPZ5g53BqwSCP0o46Q72398nzSNzT4/Zw3Z+nMx+6HqB2rzjIJpBOwz8qYSEKbtTvMYwNTBG6aZHmKxY/KMTLrW453MPKHQr5i0APqOEXxXTd6d6rETBrsoJuHw5CEGUDdvCDDvRJkzoUmmNSY7AYA1rGtYZ/oscTWxSLR2bfhpo8MEVfsEmyTXJG3Sn5u5O73Z9o/XNFneHhvXVrX7BpfPP2vNwJnP8trEIVITRBs7a1pb2dFtLtu2em869cF1y691CYTqBjm9cBotapSRQ1+AHbHlcLHLhe1s4w5cP0mCKVHEtLGFBu1NsOS+VWPp+UanXO+27x/S+h7tRZ/76rxcACP4vm7A0HC/z7d9Rt+F+8ETX69+DdJmVuxKo7HgZff4ZojrtRrzGACm++2oMMKs9dNZYMFzbIamDs/M5yAyI2cKAePrG//NQmtC2faftzvTWmrMvj5khaCz0Qlm+az0cxaYP8Xh7xm715Am2T3KTsR2pflQtsqhEg38lrBXi16mNuM1VQNwDuaBBIQvbXzeW/CSmkInfccWEwjvMEM92cnUNv9r/fMENLiG0Iq+Lf+mWY1I+9tQ8YHqpkrWI7oracsutDaSuVvelyCFRQbzKaUxxenGc0/WWG7e6c/nF9KOFrkKBmqfwHSHiwD+TB+9X17f+Jo7M8tfD8KxY783sb4J/mSykpms9Qc4pPAxtsSCUNuJakd87Gyy31X2grON6tYVo1hvbd65AUI5nvBhk39QA1jhAnp98+sePYf4wJzi2dQ2MVbQlELKlnjiRvK3a9rTaC49kT3B4d7q5xB4w9j66S4DAb54mQDJmUuEW3k1kdTOa5YN8fQ5ZaMmrntcPqswz0emjmh15rGMAiyo+JZAZIYGIgC/aeunaVoiBxT8jp8BjnOK3yGAc1IYgXGfVY4EkYR6o8q+6dBG1iPMl/4Pp645auwXfgHrHOHH6o7UOr32vl/20/dmF79FbUG7oP0BAAV487bz5wiv/P6MtMGJ6ybIgEVnYR5rrxnrpzR7PXUSptSn8okermmCIXzy3b7yZo/NQrVNU3KeoUmkZOIEO1CXSudwLSi8nfQdLW9MM7snSBChVoMyADjFAc7M9x+TNpJvCOE2WrjQ3BuP1TfnH5NWx7ySj6QZ6BvCN4URyde0JDWJ5MbUUVT5SPjhOBCWOICM2hfhNWHsprTRTjc5Q5CkNkwuasxh0jq1369b7tlzyA2rZC7zCe+kJw20J1BVgwiePOe7xW/Sd18sDHL6PZm6qm26XaCFR+obMblM7CZ5TF20u82MJHl3EvWlGjRspo2kYCEwAxeQ0AZ9w+0BQRRnaU3msU2PzGrq/WbpUwOICFAk/2F+oP2VO4XM6BfyZrHFlV+x8qOGUvssd3++1KCia6OMvgbNvBS70mXR/gbND8ESaCddNSDccdToo9x+pJQFV3xF/iZqQ840ah+1DUBYwLVAan/BFNnO8qOVHne20BB2NtWzXhHd2K1pN9PuL7Q4AGK/mIu98o0IMw3mIJ8ENrM/x99TTQcR43+kXU/aoSsgnLv9XR1kbDrIQSNcbgY3kujqSOnwx+fQ9yZgkvf+vjpMTmBhdj6QeZ8nfWETWmHj8XrikHbS2ucT0Za/a4tyScWSltIKSW5KvkHxEdpYl9BODhqhWWN15/NSx/PWtDEUmR6RNFT3r9okqChBoKzm2vhh6XusY2gH2U64S0KrF3sFhF9u/5y+iwCKOyBcUrmQgGimZvFdEtuLg3iI3fcNoFIsHQOtxa7cZNNn/7kqwCut9cPSD+jed6cHyOCcCBK+XPB864weUw9sfIUDjAYiAB1oWoGkFQbq4Mhf0A4DdQ0Rn/lqx3xWfaRGBiuEI35JVah9dhVO5xSLsPZyAjycZXfartyTIf+O8D2k4nAZ+2zHPGoT/JbTcwO52VuggLT2CtTbpAK2K+d/c4OHaBnagR0L/hUfmerXliY9on/NaEEEqDG1Maxj5AX8eWn3b88uibnQaw3IDY/MwTT+aOsce4BHD7As37XMKRBGaGND5koIp4FggiKq68wlMSbtRukrFebNNzu+9tRMkte5Je0GCbrcxLapmthZaYXyHqk32t0D2n26hHVgpUecAmGQEzfPXifmYaHgDeJac0vmaNrbdwbNFveaWRjoibWga4Rz9GBLe33T0oCw/HuvgHBxzSLSzN8vnuMWCBdUfUt9vWr3Cm0uLFfa3IbGHGMB6k3N4TK1/QPUa2z8uYjm0rjM+z0BQtmvg+OvIA29+KfNrFu4r65N8w0EtKHWZh5LEPiuYgEBGwFg/hQ9gBKom5xcS6T/F/CfyY+IoERuIJmmIdXfs8x9mcwn5O80Ub4p+5auu7whkTvXtc4Q0aOuYT70t6iqEDuPUNu9O4a0Yas0UEShhmmFXLubljuN7kO+QAB0QaD0B3LNlQMj+TcLuF8TkeMzMYuvSRzE+if24QzjyiVSs+DmYzvKjlFkkqu+nJg7XtJGhCY1LusRr3dBT4jv0twt+UCnzrSXmmzqrlSnWt57W97hbdOeqUP4BdTGd7e87eBPBIiIaKM9EtuGrdmf6enClfd8Y/O/aFGKfqE2atpQxbHyszaTxAVGp9xgN8HQZu35QPdx5ftEZBX+aRdmsfTTYuPHAoZrou5YPV1XjYaDA+iBhkwC8BLmu3gh2OcNEIbW/EB9+EHpXLdAiOcDiMXVxfB7l7wn8/jFZol3HKym0NYK1T4qPVRM61aNNjc31hn7VtJ1Pyn9iH6/eeUondakz7mIvxPdStyvVZCrhXkMagUFG/Kfk1FXHoHlYCi1w/zJusnMzVPS1vI5OM4smMmGJQ9lHUI1INSDAoMS+9HkV2kXcP6jcy+N4wTqjD0rqcAConfCRCczXL82gJlAUWubAGcRJBHm+1QCSQ6MxUe2eBrYkBEukFbRPlTAgYBsjACFr+4cx4T1j+rJDvyyT1qsrgAVJFfVRKNI3aZXPZrsZwoCH5S8K00P0jS0Z0lpXOY0WHLzijESoPGdPjE92a5jDQ6fg3tDtF8sHBTUqDla643bgfvi6sKl7477Jvk1kYVytv1i1whHy4AOxg1R3e2HXUeN8VzP5j/rCkxeFTSmXtE92PDlVzN7/93IgVanp2DziauLUgOINtem8QcGig9MY2+BMLw6ku47t+R9t0D4XdUCukdsbaR99855WmqygkKFMblrVYDTuVJ2tJzu9XT2Y80B4STx/ydyJtK1tx/hm9B83ZQHDmAOwdX0bM6T6v2GtgatkEhyJ0+dlL42B9+gq1fBZOm7A0jOXD+NBRVMZ4F50wzUERClASp+5DTtwHppiwlsf5gvk/Oe5jk/WePZS+tnUkRMBTx3L+4fnMJm5tqDJbMKZ3ljFssI15NrH6G2lhySdAh2f+ZYCYSC+Ppt+VdONTsxeaqOVtACFP4jcXrfl2VfuJq03uaTGrRC1eRS+XN4Ld+V4vBlaNs+OtcTn7kwsitL3p3s1Cx+r/htDlpy0bcn4rI3Zo1KVSGQVsAD91d5hWcLhHDoq8+Pcag+UuG0E1/f/CqN6YtFL7gNpkTURjrQPuAOksEf8rPaKINGkVEuN6zS9w00J1w7pNJLIKyJoD78aGszQKiNNdoGV40qt6SPlqa56v99Zt0TDv1UebSMwAtE6maAkMwP0N/AF1TL5237eTuBn59C7bokpmfrSrlTo8f/2fKmV0AoNDYBSDBbP97+MV1r/YE8PVjQltKBwDuzc9xslAKFCCeAYvU+bmrBtzdT5zN6BMT5gfYgig7GJhOvObOYR7hOHNQ0HT8yrQygUaHtqDDZdec22n5r+s1ufXWbf9pA5pkwO7Db8jJkS1xN2jPNJ81SF6wzIISmrco3lcHErRPRyptW3MAKjbnUhmtiLKTWEM6jpNjAVEqbpyAFCo4wWf0Ul8GnpR+fMyBEu6G9Qdu5a/Xt5PCH1gi/mAD3lwtfcutDDFhxq2bC2wx539VNtcQHFZsJ/Ie9I7o2lwyg+3LfN2iE7uaGq2sggo17Y8zdB0t0jbAu1jAP4Ie/IkHPGtFdFWJdvmMqiIKAKPrpmXWPe8S1hF8fvsgfqhcZrgOakqCkiTkF91Nr4xTKcLunAESvvOmkvQkKy4v5QezwLzyf8fqUa3j2QfRFbGjS1QZ/GX6+IuFyyolEJyPXkgaoqYo0Smh4ghLj7oXPkM+wwA6ESyoWee2/+rjkPWrHwkoDx48d/O9+zSzqKtuMAe4a5svKtXY6IR/zDQDntii8KT7R2pOT3cWkpTSqlIYkFl8XwxLr49lS7efEhgQW3xBPkWb8Lak+gSU0au+18WZitUsgxBjcsfIWSguDHwvgLCgzbxv5b2Zira7RB9LEFUVyiVgbeyE7efqUxzu5jP7/XGbQlIX5Pm/bh2Zt1OvSZO6A0DfUHhDim5NNEtzxjrQ2J0BIbdhyqIj8rjhKwiz3rPon3xyEr00zyYMrXKfcqUEt+zrg80oFDU/6MqQ2hL77fsls9z7CyoX0ObNGyDemjaxXTGe5MQl2BAJooNOppjHa+GTu4x5xLZFJcmFkF4f7fbFtvuGZMQ/vXHlbqwuakCTVL/UKCIVGCA0SgJilO9HnbftYpnpdnzqcXRrvL0muwkcAkwwamNAO5mx9l/sLd60gLc8T8xjBEUSNwR0U7UhXtCCPM0mWD2I9wzuzI78ddhjAxzVzge/67XhxhPBO7MPi95wRWaVGqA44NDA8sxszhiJGpKXopnTnUJvOCeygR6xtBvBQcp/dAuHQpKvYtcuH8IUqAh40Bm0NPiFzxFT8/c0Nr9Ezy5Q8+N00s6fmWJXXPsJtR0slF1E8G679XfniM67O0hwQdg3vqGnFKRTgqD3awKp/qWFVR8pY9t4syjvG+JiBUN0gXwQhXvvM0p2JDjePqA0la0FEqOFuwIbjhorDx6l0tmmcbIZ0S0/6ckkVD+Q1pxFyN4hN+i/N/j/4Drm2bwcncgNpG1byTs71rTxSSWP/VM7j7lw7etCTV5F6Ivtxh/7636n/sZ5RXSRvFcFRmNAKNzar1QBh4Y+F3mmE+TxAgeCGSBOq/2UngRzxlaLaszs000JoFJzDZJNm49iM24mci4G4OKob23diP3coF39AUWPPTGRuSouIMkwwb/hO2fvX8qraUZ3ZPRl3sru1BTI24w76+f/S72KDlg3gKVXKxB2WMsRhwtsLNtSSma0GS/CalT/dlW9ROuXhj8nYvYqNW/sAB8WQjnruNr/WCwWzWFVTuccaodgUcM3eUV01gLX7BqEhgYbhok26hfCVITNApGmt3ZPpsTkrq+78VODQPjjPzRlIyHCauHa8/nqMPb72YW0zmkBRS0Ttn9N9ys60cTMQYlFX2LV3gwDMMe8wz1wRyVHJhWg+K26gXG9ogXdrJjYKOMDk9tUB0E/fXPwiOrLiQ1tdRaG531XT4oQ2KubHd+XfeQWEX5RwHyV8le6DJQtJa42tiTGzB7Ls8+Z9u5YucpI1oOod1YNt+rmIiNE8WDLR1b1kkOTZnKdprVy97HJaQ1hLtJ5WB9Dv3SO66qmWnEKFPlNdI63BPCa+VNXxGgkunvgJRW4yTNT64zXSryQCCzik6d6M/5Oajii/LwiW/0i5jt2YNlJP92pH1xIBh5k5Mz33EeZOke2us2c8ZHmiDU5e97TdBwgzEDtiRDsZeRTai4jwddbpGVn7swzhf/Wa0MTsfD7OQbxFSew3aTMDROReLbiAiSivoWmBnSM7sdqmGq98hCrvcfbWt/nkw66vZ5+oB2iZTGN6OGhOoD34KZo83hdXLPAaCFc1phkq36BPYCpXHrEDO9wKfor7xG7e8nHBeKBQgtBimwNCANM2N1Fj+AxRbMRZf4IORuCvk7+hvXKHv82QoQHNRmwuaJ8p9dBhc/mk5BOl4AV/zd32gVdAiHuQ708BOGefCy77hq6PiL27NENEcHlGWBs9e4gDNXz7KxpXEjH9yTyXQEhBErApEF33C1PcEZKHy9P8RKqp4LDi55HLh7Ue81jVSuCj8xQIiVqT9yyLq+XOWFAVwFYHNw0PiQyEocsHGwmoEfZUG//o3npJJ54F0DnCl5Uc3KLTLUINgRB3kWtopDClYcp4mO5Ek6Du10bKeECbwWtCAj1eiBzjHcVliw9t4YUD5ODaS0+pJFSzSaVWGAGQEe3kWI0rbQHff1UFxCFLByjBlvasd0R3tutEnUuT3BkQJu0yEMDZVRqIiOgvmURaG9/Z/JYz7VaC+uUxfeUkFn3w2NpHvQlI8UBN+Zf2Qg96+0DjMZqb4axv7MWsT1wvdllMb4os9o29hN6pnmCMPzELPNUIEaArObzVLQi4qvZCxS60OYt8XcwDFPcoObRZe99M8wMv/E/d7NA31yYNdmu+gypjBkLwTr1J33x43QP0PdS2dAeEX27/gtZWhJLcYLqe7Af4kgWACcsNcwWMDx4secptdB1BEkqUWHM/23JkK2nGWw6X0Dv6bOvBTWR9XRjTXd9E2kgFKfvAmtZhHqvkUSxikcHRHAiB3/dK0SuygyZmP2IPkWudhwKkvcI6S20K0TU/pb6ZD4Xsn2IXRXaTNdoeynqA+xRO/kp0HNEOZ2YyOIPwU9K7ZharXD1PJtT80k+pPQ9m3evWGbVyd6o0HYSf7WJt9zOH/8XEyjqw2q6VKKalqSyW2wyEa5YN5j5BXSvFWdCNx+udTUaXQGgqusAWln9rN9d1J3k3bSNQsy+Uqid8PhQGca1Qjyxi0aM4p4cbjp1krpm50KZVN4Opnl+L+wh5ip3LXGNnZeFo/LD5AbBNhS6cSl89dY0TuDlhHDUlzZxC8fm03SlGjVfrz2uXXe1V+iYCEkhKQP69C04rp+psfY/G7DsXucz6M+PIBnb0f01s0NIr9aM22hkyifC3Z/Kechtdv37ZMEqfVNM6nQnqamJcJAdTW/emcnn+rcJPCH6VIEwL3xs0PyIrF0y1k6l1c1Q8eMnBUkqlEQsXTvpZRTMNppDd6d9eZkHg7GIUkhQ13nzDQILlXL7Y+hg9aKKTtwuek1kuqo8Qf8fPs+1mjkdpQKOSr6X2RCiEU1fCSdK6mRoqktYjzQAir/3Q6vvsFad1re66ZVd5UnmGA6FmlvgpZGb4XdWK0s6IulwraSfTqFJ3OZbhQqVhEXgR/r87jNG7LBUU4EvrHd2ZBwR0kxAbGioSeQDqcmfqH+cvtSDcE+1QJJidxXkZBkK13kbqO23z3e4k17g50H6p8CUHErErwbyUUWC9P01k4VHqJon+hMnuF9LWTiPSflcKsjqLOMu2rdu3lp7vRmPl9EnO5hAUA3z2823z3UV8JZd2w8H1FPFVeaMimDIp9ylnmrWejJBNzw3roTlZVh8nYwbCJYUCsK3JPNbLBL2jaINTHYISFCHW31GC3F4aaKpuOvGF+Fj2eNLu7H6B9qbkfb4gRqWMYC9veEmanPi7cIijRBg0EoCuLA9WMNXIdcy1a4ofbZvrcRoQCkRgIODX+PXUrw7FDMyfRxt9iX7SRj7T2Iy7zaaV/Hz1sQrWJ7q7vcKvvkDf3zbbo/JHKLOO9omJeFFkD9Zwota1RrjlXVkxWgC2mrUhJL4+1pAVIaLBStVhBzNxPkwsyk1tR64NgOJwY1kmZ88xQPLeqkM5SGsmly/5+tqy1MYVLVVwQfb5qJTrZWS6gz4PzSl2bihkwXYt72IyD+N3xrlMAxPAtmKP3VpAHU78jLJeglOoa4WGTfL2tDEGzRz98mjW/c5M9QAzz/TBNfdQ/39bNt+VL1L2xxRtnaIv3tj0ijsg7CL4tBDUJxV+UJ4Xzuc8MlJMQCgBFBXQ0aYpRneRvysFBMcn8PnXhisVmiaNepetQiuUztzSuXb/n8FXONVQeAEmaWQdz+ltOIZIcXcyf4UqjbxGnJ8hUr5EEVAKnSumAULqiJp1jfCVZaS6Rfmwan3Rh1aFSPCjHOj1k2XbpsqiEPznz0vmNZe9IWXC2oeoTXem3+KuFJGcVAX7C6kisI+YINogQjNS/TRKTjBJys40ogj4KA5k+K2WOdIxcN95IsuHa4QDJX0GkxGmccOJepecu1c3vcid3dp9BICCeOtM7llzt0ytEhSf7tG+lCCvamnqszy5bqKM+BHFRzMBpxcFmi8NDfA+VRPEZoazQ+wFU23sXSd+yTMEQMOYIkWTNisEdkI6Uv9tOVjsLiuHrqE+J0i+WJwm14eI0Asz11C95sq4/jT37Rw5bcMrftfcNxJo4+sSuKUgSPd6ymFw2ddutSl+SmR7ybs1+XVFf0hW932r76YxdlKVOsjJPJdz6eOtHxsK/HbT5pOqEaqfRTLChVF+NL4R9WEOioFyfTm3gwqmmc7oac9uTbvR2Ubg/6cBIWgwqhbIS13ZK9DANCUCde5UVneC56e+B7Z8hJ2rhh0Rp5mRqawAoZ80W+zpSfj8gqoF7PrUa+VOhAUzW88QQWUbAB1AEHxBQZ4OdEi3C2RfKGlQrgaZHCp70nnkVJskzxkHWDUNbergSU0BZu4PHaQfNCD9NreTF1WiUcKLzH74yLQF0yOyG4usDnPve4rxl8EJgCHoPaDmuBJUciFQC7VXNUH5JWcC7hY0YZH+J3iG16UMc6jIoi74J9Y9aljs+A5McneCqiWqNfDapteadQ+cSWUebMa9orvpxG87wGBuufIvmq+BoytwxgmucY3RdJdg6Ox7SK/jnEKbTCXro/Vv5bFqh/4UP4/PGieLkEA5EIGkFwpfNETSuc9yE5uWM5lbW1qfo5qMk6CZoU2gvVApOc0EH5jY32Vmkqt1AqtMjDE2v+dyn3M6viBa++oR/Zz9a131s6GCLACTcy9tUrHAnF1UscilH/gPB8JPt32qUFOmSSA0mMiFU6jYpuq8hVkg6Cbw+fHKtjZDBRc1WuajUxMwGZDa93x+ECcfh3O6Cigokvqx+T9KxZtApQKNkdiN5G4nQCi5dvBnvlz4Amlpog1YPP/WzF5Tvi2+00VMXJQwejL3CZ3mc4GMegktB5wysPEVjS1LnVSVxyrZU2sf17M02snUwwfX3E/a4W57wQP2szaBcXiTPTvFblpvOmTQ2MjsQ3oWXBB8IbaRPDBe39GXdl9kqJgizixjTxqBrZ/OtxOpTwg4lBwuNWt58lk+3fohbXR+SqrcuIx7WeY+GfkjLRAlwG7SdnksXoBz/8RLKSrcEiComqY4LOrbioXsxtR/yMwZcbgRMROiutOBRokNcWr9zGD1Gvn711Ell2t0/ynXlNuQJhVZF6W6ToLU1Ewcb4CagD2j/WTWiqTWaIrBFQn9iJ5TdHC9AMJStS/HrX1Q0sqEpUTjpllJqHsIyhVcEMLnCf+dqZhqkLk/cHbL/PLP2HBt/QiCNMb2uuXD2Zc7PmVr96xxAHZXYAjun1ivqt8Tmw4ype7NGMs5gQAz7T6jk0eyz8rns9JD0i8botYzADh/Wx5MzyZdZhHtZBsxV7CWV9hz5LP+NCCct/UTB3qKrP5CkVvuK8zYt0pnk6/WS763lelGb2m7/hc75hsc8oaSVrKUOgcFVIWOrY9iHULbGCLK2Xt50cgEbRIH6ibxjLxAAyhSjrMOhJ+VfuoSCMuOlEmtFEAIykyviC76oUr8IJyqw9UGIBSL+sKIntQuUG1QuLVneFfS6kAGxzVEe1F9WDGDHDRRFPDEiWso9eVn8JW2oRze/gn9DZVZ8P/L4v3ZXem3sre3vqUuSJJHMh+QCwnP011bQDCh0SZokDgOVLgkTKXZSUA2Ri29wdp9/VAzTlAatDFUQHcCczjJrlTr80l0vKSvPMyoPbUBqZPdIjpJQAZXcXbxbPb7qd9aDAT1qkm0SY1cPoLajeek59fGBkc+oC14Yazh78MGNCVvsmGBimuMSObWCLKH0HcAnG4R3aWFAyqXCQgLeR7yzfScYj6h7zEv4CZCNB48SYDyGKUCtrkvkdYKhgCZiDptBUqFYBsgqIisp0cyHzT4O819KJ5lVNpoue7wLHxedNMDkXxclMBMgAuXA0WSm347yobED6TvPZI9Tt4YpcTEBo0CKlgXSCIQ83nCGmmKx6lAuKDsGw54kR35d7Tx6k7f76aPnR8d8IVqSGau6B8OhCBhqoRpM3UFpnFQ3jS282iDtPcFx4xHU1EHL4kcp4617Gx2/6BiJmMy40BzNbCC9xlF02Xit4hWiyMEpjvJRV5YttCtRgiydZ1mrtQ17dTM+jryQ9YfraP0Kxzh6UojxLPu1D8D8xTf5deqpXf8zfT9IFd+LBmh0zQZaJGvbXhFMzueIZ8lXth0ABzxdXHEv3IhhYL3ifuDn4g24FjW+iMNrO54I2+n9pxO2hbsLDqLit7Z+7O0+0bRmceKf2yCO/7dmj3pdEwAovtPZD5KJh98h1/s+JIV/VTkrO3zWMsc8E5tQfkwjE3t8Vp9TPQx0sYGFccbjlVRP6BvXNGdcD4xyOqomi7mSIM2L/Cd2uOGvpugpkUiik/X1j4LN1HNMf55cS30O/4Ok9ukiTr0Zd6BAkpNRQYS0tkm5UxkLxQFkcavpKG5C07R9fY0NWjtqdHna63WHn2+I83weL35eQKaq8q048h2OsXRHHhDH9Ufa+TrSbt29Qn+rOh3KA/CmDNnn9j7mK8fXAPtxXepv/C3X3b++RohAiDmMv1C8xI/v1ls5+uBJmNPv+JUAADX2JW3G8otmct1i8glPxayJ5XquSLuMulAxndRKFXmvRa9IovD8grak5SaiVxLXbo70SMfoYdVXRx8hN58/yxLbTmIDsrBOkgH6NHIM2qbp+3R7zG0hZ7DcPJhC8zXoDPsR5inA87gGmrmzX1nOIwB7oI9nvInXdCugs52nrqKJJ+hHFGoQ/5nOGf+FB/hEZFWJVLnRFCCF0GdJMFQFJIsObxFrzhsJw6Db3fgvz+RuWEm+Dq89O/Al4UyRyA2izM+fCmlqx2RWyGgd6jRawHWspJ23nN0QJSLzA1PFrCraNoZ89uaiXae1TV1Evxsc3reGVzHoT36NWczNwUzz7RPW3C+egvKhbq/c0ALzIsuOhiGiHXj4QZmO1f96EV/eD1PTdXRA9zdR988HTa9c7GWzhUQhgi/ANLsZuTo/jcUVUA5/typdLodQEckyiPnVJRnEv5BFDP99fT/2MD4fs0DoX66FXwjqHLx8uYX7ZQRqpXWQVbmQMBCPTuFqs/k6ifXaWYZgiCthpRpiSWWnJ+i+gWQemYwj0GiXs9Pj4N2KPI34R+0Bzf0CinrZ7BTp05RJWNPgFBQMXDwE+qnwc/IiwIYD8Yp+nEDAZ8gdINKIzRXtDW44pvWk6ZjiSWWnLdA2EWo+aipJ84Hloc2CbqKZoKiHDfk/ox7HCLCqLt3kp32GAgF5WbzT5vocHVj5REbuyv9du7Mb6py0AhFNBuv0iMlrSNx2xJLLDnvwVA6XD/a/KGsQi0ACObx84UzZPRtVPJIo2angdqCsmACQqo+7QEQCuBDxVwc9qKWMadSXUnDOXfpRKOeUmePaIvT7RChtMxiSyyxpKWAUKaUlTdtN1BUoH0BCJH7K2RY8tWylqAoQIqUOBRyH7x0oMcgiJ9RNw4HmKs+RwRThiXxg8eRuzlT91FKYnf+syxofRCRkHX5zTKLLbHEkhbVCpN2L5WlrkQ2h1rzD0nudm6gfv6CfhDNTck3eKgR2igVb/fx3VSoQK17R2euJg9nxlqJKpVnKks3VjieYI2gJZZY0lJaoQxxL6xewIMkSLfLe469pERnuY9QTwOjwqtt5PGMj2U/1CwIitShfgkXs/+e+oVKJvnISrY2nr62kp8DAfKqOG+Zm8WBLLzGkK8bZ2mDllhiyTkDQ6TGCL4ezFPhI3x5w8uylJPIIhE1AelQZzW9Tk+uVuvliTQdnGtAtdZ2Z8qULR9ZOGCazmSvNeQVL65c3KIpW5ZYYoklzYIhyhOJcleiCsqavasJ0KjAog56qENIKUP7svUCCu1k+SVfOrmsrR0Y9Woa72x5Qy8t/rlSQYVnq6A+migwAB8l7h9nPIzGAkFLLLHkjwNDnOsxM2+GodLI9ckjZJ06gBeq1DadamLHTh6n8j/iPAeZdxzRTmahiDzkzQeQU3uKynirpjNS7oSs2J3Oggqny0IMFghaYoklfxoYIhUOfD9ZZLIhXtf6bJRuBy3ue/0wc1S7VoMpIkpM2SN6UVCUsCJ6zH8bqVIGzzZpSz5H4W+EZO7LNJzZYYGgJZZY8qeCoVn+veFlgyaHMlM7mxrZ0d+PscvjLrFrgEqZJ0G3WdqQwE6zk3TuiDhOE1Hj+1aNPaOEcUssscSScw2G6slfhlLuONNDnF8KsLsh+TrSHpN3p1LtMXlGbQgv14/fJ+VMIs7hR1ve06vU8uAJjnk01d4LNp84Zo2IJZZY0io1RdBZhqDIZCg/yR6VjHGk5+iU62U5eJi9VHA08TL2RdlnVOW2syjuqf0fBRRclS6yxBJLLDlvzOavt8+n0+kAiAii4Fxcfq7BBdJ8xrms4hwPHPo8ce14tu7AWnP5ooCWql9niSWWWPJHmc0G4ZknjtVm1OM9n8p5Qk2Rs3yAllhiyV8LEENrfpC0GZlXHNFBHnSDl+k4zN8sH6AllljyVwHEILtWOIIOJhq/dhyLq41lX5d9xYYlDWGXxPiz+9fca6XIWWKJJX9pzdDrc0KsnrPEEktaWv4fWcZcyZAV1qYAAAAASUVORK5CYII=";
        $logo->merge($con);
        
        
        
    }

}
