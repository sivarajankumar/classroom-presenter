/*
 *  Licensed to the Apache Software Foundation (ASF) under one or more
 *  contributor license agreements.  See the NOTICE file distributed with
 *  this work for additional information regarding copyright ownership.
 *  The ASF licenses this file to You under the Apache License, Version 2.0
 *  (the "License"); you may not use this file except in compliance with
 *  the License.  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 *
 */
package org.apache.tools.ant.util;

import java.io.Reader;
import java.io.IOException;

/**
 * input stream tokenizers implement this interface
 *
 * @version Ant 1.6
 */
public interface Tokenizer {
    /**
     * get the next token from the input stream
     * @param in the input stream
     * @return the next token, or null for the end
     *         of the stream
     * @throws IOException if an error occurs
     */
    String getToken(Reader in) throws IOException;

    /**
     * return the string between tokens, after the
     * previous token.
     * @return the intra-token string
     */
    String getPostToken();
}
