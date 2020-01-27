<template>
  <div>
    <template>
      <v-toolbar flat color="white">
        <v-toolbar-title>RAB</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>

        <v-text-field
            flat
            solo-inverted
            hide-details
            prepend-inner-icon="search"
            label="Search"
            class="hidden-sm-and-down"
            color="blue"
            v-model="search"
        >
        </v-text-field>
      
        <div class="flex-grow-1"></div>
        <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
          <template v-slot:activator="{ on }">
            <v-btn color="blue" dark v-on="on">New</v-btn>
          </template>
          <v-card color="">

            <v-toolbar dark color="teal">
              <v-btn icon dark @click="dialog = false">
                <v-icon>close</v-icon>
              </v-btn>
              <v-toolbar-title>New RAB</v-toolbar-title>
              <v-spacer></v-spacer>
              <v-toolbar-items>
                <v-btn dark text @click="addAllItem">Save</v-btn>
              </v-toolbar-items>
            </v-toolbar>

            <template>
              <v-card>
                <v-tabs 
                  color="white"
                  background-color="blue"
                >
                  <v-tab>
                    <v-icon left>payment</v-icon>
                    Data
                  </v-tab>
                  <v-tab>
                    <v-icon>home</v-icon>
                    Structure
                  </v-tab>
                  <v-tab>
                    <v-icon left>group_work</v-icon>
                    Floor
                  </v-tab>
                  <v-tab>
                    <v-icon left>work</v-icon>
                    Sub
                  </v-tab>
                  <v-tab>
                    <v-icon left>work_outline</v-icon>
                    Detail 
                  </v-tab>

                  <!-- Fom RAB awal -->
                  <v-tab-item>
                    <Vform> 
                      <v-card-text>
                        <v-layout>
                          <v-text-field
                            v-model="rab.kode"
                            label="ID"
                          >
                          </v-text-field>
                        </v-layout>

                        <v-layout>
                          <v-select
                            v-model="rab.id_project"
                            label="Project"
                            :items="project"
                            item-text="name"
                            item-value="id_project" 
                            :return-object="false"
                            ></v-select>
                        </v-layout>

                        <v-layout>
                          <v-text-field
                            v-model="rab.desc"
                            label="Note"
                            >
                          </v-text-field>
                        </v-layout>

                        <v-layout>
                          <v-text-field
                            v-model="rab.total_rab"
                            label="Nominal"
                          ></v-text-field>
                        </v-layout>
                      </v-card-text>
                    </Vform>
                  </v-tab-item>
                  <!-- Form Structure -->
                  <v-tab-item>
                    <v-form>
                      <v-card-text>
                        <v-layout>
                          <v-text-field
                            label="Building"
                            v-model="gedung">
                          </v-text-field>
                          <v-btn class="ma-3" color="light-green accent-1" @click="addStructure">Add</v-btn>
                        </v-layout>

                          <VBtn
                            color="light-blue darken-4"
                            fab dark
                            @click="tambahS=true"
                          >
                          New  
                          </VBtn>

                          <v-flex class="text-md-center" sm12 mt-2>
                            <VCard
                              v-for="detail_structure in Structure"
                              :key="detail_structure.id_structure"
                              > 
                                <v-card-title>
                                <v-btn 
                                    icon
                                    color="red"
                                    dark @click="deletestructure(detail_structure.id_structure)"
                                    >
                                    <v-icon>remove_circle</v-icon>
                                </v-btn>
                                <!-- buat ditampilkan setelah di clik addList -->
                                <v-flex >
                                  <v-select
                                    label="Building" 
                                    class="pa-1"
                                    v-model="detail_structure.id_structure"
                                    item-text="name"
                                    item-value="id_structure"
                                    :items="structure"
                                    required 
                                  ></v-select>
                                </v-flex>
                              </v-card-title>
                            </Vcard>
                          </v-flex>
                            
                          <v-layout v-if="tambahS">
                            <v-flex class="text-md-center" sm12 mt-2>
                              <VCard> 
                                <v-card-title>
                                <v-btn 
                                    icon
                                    color="red"
                                    dark @click="tambahS=false"
                                    >
                                    <v-icon>remove_circle</v-icon>
                                </v-btn>
                                <v-btn 
                                    icon
                                    color="green"
                                    dark @click="addstructure();tambahS=false"
                                    >
                                    <v-icon>add_circle</v-icon>
                                </v-btn>
                                <!-- buat pertama kali input data untuk addList -->
                                  <v-flex >
                                    <v-select
                                      v-model="structure_data.id_structure"
                                      :items="structure"
                                      label="Building"
                                      item-text="name"
                                      item-value="id_structure"
                                    >
                                    </v-select>
                                  </v-flex>
                                </v-card-title>
                              </Vcard>
                            </v-flex>
                          </v-layout>
                      </v-card-text>
                    </v-form>
                  </v-tab-item>
                  <!-- Form Floor -->
                  <v-tab-item>
                    <v-form>
                      <v-card-text>
                        <v-layout>
                          <v-text-field
                            label="Floor"
                            v-model="sub_item">
                          </v-text-field>
                          <v-btn class="ma-3" color="light-green accent-1" @click="addGroup">Add</v-btn>
                        </v-layout>

                          <VBtn
                            fab dark
                            color="light-blue darken-4"
                            @click="tambahF=true"
                          >
                          New
                          </VBtn>

                          <v-flex class="text-md-center" sm12 mt-2>
                            <VCard
                              v-for="detail_group in Groups"
                              :key="detail_group.id_group"
                              > 
                                <v-card-title>
                                <v-btn 
                                    icon
                                    color="red"
                                    dark @click="deletefloor(detail_group.id_group)"
                                    >
                                    <v-icon>remove_circle</v-icon>
                                </v-btn>
                                <!-- buat ditampilkan setelah di clik addList -->
                                <v-flex>
                                  <v-select
                                    label="Structure" 
                                    class="pa-1"
                                    v-model="detail_group.id_structure"
                                    item-text="name"
                                    item-value="id_structure"
                                    :items="Structure"
                                    required 
                                  ></v-select>
                                </v-flex>
                              
                                <v-flex xs12 sm4 md4>
                                  <v-select
                                  label="Floor*" 
                                  class="pa-1"
                                  v-model="detail_group.id_group"
                                  :items="sub"
                                  item-text="name"
                                  item-value="id_group"
                                  required
                                  ></v-select>
                                </v-flex>
                              </v-card-title>
                            </Vcard>
                          </v-flex>
                            
                          <v-layout v-if="tambahF">
                            <v-flex class="text-md-center" sm12 mt-2>
                              <VCard> 
                                <v-card-title>
                                <v-btn 
                                    icon
                                    color="red"
                                    dark @click="tambahF=false"
                                    >
                                    <v-icon>remove_circle</v-icon>
                                </v-btn>
                                <v-btn 
                                    icon
                                    color="green"
                                    dark @click="addfloor();tambahF=false"
                                    >
                                    <v-icon>add_circle</v-icon>
                                </v-btn>
                                <!-- buat pertama kali input data untuk addList -->
                                  <v-flex xs12 sm4 md4>
                                    <v-select
                                      label="Building" 
                                      class="pa-1"
                                      v-model="group_data.id_structure"
                                      item-text="name"
                                      item-value="id_structure"
                                      :items="Structure"
                                      required 
                                    ></v-select>
                                  </v-flex>
                                  
                                  <v-flex xs12 sm4 md4>
                                    <v-select
                                    label="Floor*" 
                                    class="pa-1"
                                    v-model="group_data.id_group"
                                    :items="sub"
                                    item-text="name"
                                    item-value="id_group"
                                    required
                                    ></v-select>
                                  </v-flex>

                                  </v-card-title>
                              </Vcard>
                            </v-flex>
                          </v-layout>
                      </v-card-text>
                    </v-form>
                  </v-tab-item>
                  <!-- Form Type of Task -->
                  <v-tab-item>
                    <v-form>
                      <v-card-text>
                        <v-layout>
                          <v-text-field
                            label="Type of Task"
                            v-model="sub_item">
                          </v-text-field>
                          <v-btn class="ma-3" color="light-green accent-1" @click="addTaskSub">Add</v-btn>
                        </v-layout>

                          <VBtn
                            fab dark
                            color="light-blue darken-4"
                            @click="tambahT=true"
                          >
                          New
                          </VBtn>

                          <v-flex class="text-md-center" sm12 mt-2>
                            <VCard
                              v-for="detail_task in TaskSub"
                              :key="detail_task.id_sub"
                              > 
                                <v-card-title>
                                <v-btn 
                                    icon
                                    color="red"
                                    dark @click="deletetasksub(detail_task.id_sub)"
                                    >
                                    <v-icon>remove_circle</v-icon>
                                </v-btn>
                                <!-- buat ditampilkan setelah di clik addList -->
                                <v-flex xs12 sm4 md4>
                                  <v-select
                                  label="Sub*" 
                                  class="pa-1"
                                  v-model="detail_task.concatenate"
                                  :items="Groups"
                                  item-text="concatenate"
                                  item-value="concatenate"
                                  required
                                  ></v-select>
                                </v-flex>

                                <v-flex>
                                  <v-select
                                    label="Type of Task" 
                                    class="pa-1"
                                    v-model="detail_task.id_sub"
                                    item-text="name"
                                    item-value="id_sub"
                                    :items="type"
                                    required 
                                  ></v-select>
                                </v-flex>

                              </v-card-title>
                            </Vcard>
                          </v-flex>
                            
                          <v-layout v-if="tambahT">
                            <v-flex class="text-md-center" sm12 mt-2>
                              <VCard> 
                              <v-card-title>
                              <v-btn 
                                  icon
                                  color="red"
                                  dark @click="tambahT=false"
                                  >
                                  <v-icon>remove_circle</v-icon>
                              </v-btn>
                              <v-btn 
                                  icon
                                  color="green"
                                  dark @click="addtasksub();tambahT=false"
                                  >
                                  <v-icon>add_circle</v-icon>
                              </v-btn>
                              <!-- buat pertama kali input data untuk addList -->
                                <v-flex xs12 sm4 md4>
                                  <v-select
                                  label="Sub*" 
                                  class="pa-1"
                                  v-model="tasksub_data.concatenate"
                                  :items="Groups"
                                  item-text="concatenate"
                                  item-value="concatenate"
                                  required
                                  ></v-select>
                                </v-flex>

                                <v-flex xs12 sm4 md4>
                                  <v-select
                                    label="Type of Task" 
                                    class="pa-1"
                                    v-model="tasksub_data.id_sub"
                                    item-text="name"
                                    item-value="id_sub"
                                    :items="type"
                                    required 
                                  ></v-select>
                                </v-flex>

                                </v-card-title>
                              </Vcard>
                            </v-flex>
                          </v-layout>
                      </v-card-text>
                    </v-form>
                  </v-tab-item>
                  <!-- Form Detail -->
                  <v-tab-item>
                    <v-card>
                      <v-form>
                        <v-card-text>
                          <VBtn
                            depressed
                            fab dark
                            color="light-blue darken-4"
                            @click="tambah=true"
                          >
                          New
                          </VBtn>
                        
                          <v-flex class="text-md-center" sm12 mt-2>
                            <VCard
                              v-for="detail in details"
                              :key="detail.id_ahs"
                            > 
                              <v-card-title>
                              <v-btn 
                                  icon
                                  color="red"
                                  dark @click="deleteList(detail.id_ahs)"
                                  >
                                  <v-icon>remove_circle</v-icon>
                              </v-btn>

                              <v-flex xs12 sm4 md4> 
                                  <v-select 
                                    label="Type of Task" 
                                    class="pa-1"
                                    v-model="detail.concatenate"
                                    item-text="concatenate_task"
                                    item-value="concatenate_task"
                                    :items="TaskSub"
                                    required 
                                  ></v-select>
                                </v-flex>

                                <v-flex xs12 sm4 md4> 
                                  <v-select 
                                    label="AHS" 
                                    class="pa-1"
                                    v-model="detail.id_ahs"
                                    item-text="name"
                                    item-value="id_ahs"
                                    :items="ahs"
                                    @change="getSelectedIndex"
                                    required 
                                  ></v-select>
                                </v-flex>
                              
                              <v-flex xs12 sm4 md4>
                                <v-select
                                  label="Status" 
                                  class="pa-1"
                                  v-model="detail.id_ahs"
                                  item-text="status"
                                  item-value="id_ahs"
                                  :items="ahs"
                                  @change="getSelectedIndex"
                                  required 
                                  disabled
                                ></v-select>
                              </v-flex>

                              <v-flex>
                                <v-select
                                  label="HSP" 
                                  class="pa-1"
                                  v-model="detail.id_ahs"
                                  item-text="total"
                                  item-value="id_ahs"
                                  :items="ahs"
                                  @change="getSelectedIndex"
                                  required 
                                  disabled
                                ></v-select>
                              </v-flex>

                              <v-flex>
                                <v-text-field
                                  v-model="detail.volume"
                                  label="Volume"
                                  class="pa-1"
                                >
                                </v-text-field>
                              </v-flex>

                              <v-flex xs12 sm4 md4>
                                <v-text-field
                                  v-model="detail.coefficient"
                                  label="Adjustment*"
                                  class="pa-1"
                                >
                                </v-text-field>
                              </v-flex>

                              <!-- <v-flex xs12 sm4 md4>
                                <v-text-field
                                  v-model="detail.hp"
                                  label="HP"
                                  class="pa-1"
                                >
                                </v-text-field>
                              </v-flex> -->

                              </v-card-title>
                            </Vcard>
                          </v-flex>

                          <v-layout v-if="tambah">
                            <v-flex class="text-md-center" sm12 mt-2>
                              <VCard> 
                                <v-card-title>
                                <v-btn 
                                    icon
                                    color="red"
                                    dark @click="tambah=false"
                                    >
                                    <v-icon>remove_circle</v-icon>
                                </v-btn>
                                <v-btn 
                                    icon
                                    color="green"
                                    dark @click="addList()"
                                    >
                                    <v-icon>add_circle</v-icon>
                                </v-btn>

                                <v-flex xs12 sm4 md4> 
                                  <v-select 
                                    label="Type of Task" 
                                    class="pa-1"
                                    v-model="rab_details.concatenate"
                                    item-text="concatenate_task"
                                    item-value="concatenate_task"
                                    :items="TaskSub"
                                    required 
                                  ></v-select>
                                </v-flex>

                                <v-flex xs12 sm4 md4> 
                                  <v-select 
                                    label="AHS" 
                                    class="pa-1"
                                    v-model="AHS.id_ahs"
                                    item-text="name"
                                    item-value="id_ahs"
                                    :items="ahs"
                                    @change="getSelectedIndex"
                                    required 
                                  ></v-select>
                                </v-flex>
                                
                                <v-flex>
                                  <v-select
                                    label="Status" 
                                    class="pa-1"
                                    v-model="AHS.id_ahs"
                                    item-text="status"
                                    item-value="id_ahs"
                                    :items="ahs"
                                    @change="getSelectedIndex"
                                    disabled
                                    required 
                                  ></v-select>
                                </v-flex>

                                <v-flex xs12 sm4 md4>
                                  <v-select
                                    label="HSP" 
                                    class="pa-1"
                                    v-model="AHS.id_ahs"
                                    item-text="total"
                                    item-value="id_ahs"
                                    :items="ahs"
                                    @change="getSelectedIndex"
                                    disabled
                                    required 
                                  ></v-select>
                                </v-flex>

                                <v-flex>
                                  <v-text-field
                                    v-model="rab_details.volume"
                                    label="Volume"
                                    class="pa-1"
                                  >
                                  </v-text-field>
                                </v-flex>

                                <v-flex xs12 sm4 md4>
                                  <v-text-field
                                    v-model="rab_details.coefficient"
                                    label="Adjustment*"
                                    class="pa-1"
                                  >
                                  </v-text-field>
                                </v-flex>

                                <!-- <v-flex xs12 sm4 md4>
                                  <v-text-field
                                    v-model="rab_details.hp"
                                    label="HP"
                                    class="pas-1"
                                  >
                                  </v-text-field>
                                </v-flex> -->

                                </v-card-title>
                              </Vcard>
                            </v-flex>
                          </v-layout>

                        </v-card-text>
                      </v-form>
                    </v-card>
                  </v-tab-item>
                </v-tabs>
              </v-card>
            </template>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>

    <v-dialog v-model="dialog3" max-width="500px">
      <v-card>
        <v-card-title>
          <span class="headline">Edit RAB</span>
        </v-card-title>
      
        <Vform> 
          <v-card-text>
            <v-layout>
              <v-text-field
                v-model="rab.kode"
                label="ID"
              >
              </v-text-field>
            </v-layout>

            <v-layout>
              <v-select
                v-model="rab.id_project"
                label="Project"
                :items="project"
                item-text="name"
                item-value="id_project" 
                :return-object="false"
                ></v-select>
            </v-layout>

            <v-layout>
              <v-select
                v-model="rab.sub"
                label="Lantai"
                :items="sub"
                item-text="name"
                item-value="name" 
                :return-object="false"
                ></v-select>
            </v-layout>

            <VBtn
              depressed
              color="primary"
              @click="tambah=true"
            >
            Add
            </VBtn>
          
            <v-flex class="text-md-center" sm12 mt-2>
                <VCard
                v-for="detail in details"
                :key="detail.id_ahs"
                > 
                  <v-card-title>
                  <v-btn 
                      icon
                      color="red"
                      dark @click="deleteList(detail.id_ahs)"
                      >
                      <v-icon>remove_circle</v-icon>
                  </v-btn>

                  <v-flex>
                    <v-select row
                      v-model="detail.type"
                      :items="type"
                      item-text="name"
                      item-value="name"
                      label="Type of Task"
                      required
                    >
                    </v-select>
                  </v-flex>

                  <v-flex>
                    <v-select
                      label="AHS" 
                      class="pa-1"
                      v-model="detail.id_ahs"
                      item-text="name"
                      item-value="id_ahs"
                      :items="ahs"
                      @change="getSelectedIndex"
                      required 
                    ></v-select>
                  </v-flex>
                  
                  <v-flex xs12 sm4 md4>
                    <v-select
                      label="Status" 
                      class="pa-1"
                      v-model="detail.id_ahs"
                      item-text="status"
                      item-value="id_ahs"
                      :items="ahs"
                      @change="getSelectedIndex"
                      required 
                      disabled
                    ></v-select>
                  </v-flex>

                  <v-flex xs12 sm4 md4>
                    <v-select
                      label="Total" 
                      class="pa-1"
                      v-model="detail.id_ahs"
                      item-text="total"
                      item-value="id_ahs"
                      :items="ahs"
                      @change="getSelectedIndex"
                      required 
                      disabled
                    ></v-select>
                  </v-flex>

                  <v-flex>
                    <v-text-field
                      v-model="detail.volume"
                      label="Volume"
                      class="pa-1"
                    >
                    </v-text-field>
                  </v-flex>

                  <v-flex>
                    <v-text-field
                      v-model="detail.coefficient"
                      label="Coefficient*"
                      class="pa-1"
                    >
                    </v-text-field>
                  </v-flex>
                  </v-card-title>
                </Vcard>
              </v-flex>
              
              <V-layout v-if="tambah">
                  <VCard> 
                  <v-card-title>
                  <v-btn 
                      icon
                      color="red"
                      dark @click="tambah=false"
                      >
                      <v-icon>remove_circle</v-icon>
                  </v-btn>
                  <v-btn 
                      icon
                      color="green"
                      dark @click="addList()"
                      >
                      <v-icon>add_circle</v-icon>
                  </v-btn>

                  <v-flex>
                    <v-container row>
                      <v-select row
                        v-model="rab_details.type"
                        :items="type"
                        item-text="name"
                        item-value="name"
                        label="Type of Task"
                        required
                      ></v-select>
                      <v-btn 
                        width="50px" 
                        color="blue" 
                        @click="dialog5=true"
                      > 
                      Add
                      </v-btn>
                    </v-container>
                  </v-flex>

                  <template>
                    <v-dialog v-model="dialog5" width="300px" style="color: blue">
                      <v-card-text>
                        <v-layout>
                          <v-text-field
                            label="Type of Task"
                            v-model="jenis">
                          </v-text-field>
                        </v-layout>
                        <div class="flex-grow-1"></div>
                          <v-btn class="ma-2" rounded color="green" dark @click="dialog5=false">Cancel</v-btn>
                          <v-btn class="ma-2" rounded color="orange" dark @click="addTaskSub()">Save</v-btn>                  
                      </v-card-text>
                    </v-dialog>
                  </template>

                  <v-flex>
                    <v-select
                      label="AHS" 
                      class="pa-1"
                      v-model="AHS.id_ahs"
                      item-text="name"
                      item-value="id_ahs"
                      :items="ahs"
                      @change="getSelectedIndex"
                      required 
                    ></v-select>
                  </v-flex>

                  <v-flex xs12 sm4 md4>
                    <v-select
                      label="Status" 
                      class="pa-1"
                      v-model="AHS.id_ahs"
                      item-text="status"
                      item-value="id_ahs"
                      :items="ahs"
                      @change="getSelectedIndex"
                      disabled
                      required 
                    ></v-select>
                  </v-flex>

                  <v-flex xs12 sm4 md4>
                    <v-select
                      label="Total" 
                      class="pa-1"
                      v-model="AHS.id_ahs"
                      item-text="total"
                      item-value="id_ahs"
                      :items="ahs"
                      @change="getSelectedIndex"
                      disabled
                      required 
                    ></v-select>
                  </v-flex>

                  <v-flex>
                    <v-text-field
                      v-model="rab_details.volume"
                      label="Volume"
                      class="pa-1"
                    >
                    </v-text-field>
                  </v-flex>

                  <v-flex>
                    <v-text-field
                      v-model="rab_details.coefficient"
                      label="Coefficient*"
                      class="pa-1"
                    >
                    </v-text-field>
                  </v-flex>
                  </v-card-title>
                </Vcard>
              </v-layout>

            <v-layout>
              <v-flex>
                <v-text-field
                  v-model="rab.total_rab"
                  label="Total RAB"
                ></v-text-field>
              </v-flex>
            </v-layout>

            <v-layout>
              <v-text-field
                v-model="rab.desc"
                label="Description"
                >
              </v-text-field>
            </v-layout>

          </v-card-text>
        </Vform>

        <v-card-actions>
          <div class="flex-grow-1"></div>
          <v-btn class="ma-2" rounded color="green" dark @click="close">Cancel</v-btn>
          <v-btn class="ma-2" rounded color="orange" dark @click="updateItem(rab.id_rab)">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="dialog4" max-width="600px">
      <template>
        <div>
          <v-data-table
            :headers="headers2"
            :items="rab_details"
            class="elevation-1"
          ></v-data-table>
        </div>
      </template>
    </v-dialog>

    <v-row justify="center">
      <v-expansion-panels accordion>
        <v-expansion-panel>
            <v-data-table 
              :headers="headers"
              :items="RAB"
              :search="search"
              class="my-data-table"
            >
            <template v-slot:item.action="{ item }">
              <v-expansion-panel-header>
              <v-dialog v-model="dialog3" max-width="500px">
                <template v-slot:activator="{ on }">
                  <v-icon
                    small
                    class="mr-2"
                    color="green"
                    @click="itemHandler2(item)"
                    v-on="on"
                  >
                    edit
                  </v-icon>
                </template>
                <v-card>
                  <v-card-title>
                    <span class="headline">Edit RAB</span>
                  </v-card-title>
          
                  <Vform> 
                    <v-card-text>
                      <v-layout>
                        <v-text-field
                          v-model="rab.kode"
                          label="ID"
                        >
                        </v-text-field>
                      </v-layout>

                      <v-layout>
                        <v-select
                          v-model="rab.id_project"
                          label="Project"
                          :items="project"
                          item-text="name"
                          item-value="id_project" 
                          :return-object="false"
                          ></v-select>
                      </v-layout>

                      <v-layout>
                        <v-select
                          v-model="rab.sub"
                          label="Lantai"
                          :items="sub"
                          item-text="name"
                          item-value="name" 
                          :return-object="false"
                          ></v-select>
                      </v-layout>

                      <VBtn
                        depressed
                        color="primary"
                        @click="tambah=true"
                      >
                      Add
                      </VBtn>
                    
                      <v-flex class="text-md-center" sm12 mt-2>
                          <VCard
                          v-for="detail in details"
                          :key="detail.id_ahs"
                          > 
                            <v-card-title>
                            <v-btn 
                                icon
                                color="red"
                                dark @click="deleteList(detail.id_ahs)"
                                >
                                <v-icon>remove_circle</v-icon>
                            </v-btn>

                            <v-flex>
                              <v-select row
                                v-model="detail.type"
                                :items="type"
                                item-text="name"
                                item-value="name"
                                label="Type of Task"
                                required
                              >
                              </v-select>
                            </v-flex>

                            <v-flex>
                              <v-select
                                label="AHS" 
                                class="pa-1"
                                v-model="detail.id_ahs"
                                item-text="name"
                                item-value="id_ahs"
                                :items="ahs"
                                @change="getSelectedIndex"
                                required 
                              ></v-select>
                            </v-flex>
                            
                            <v-flex xs12 sm4 md4>
                              <v-select
                                label="Status" 
                                class="pa-1"
                                v-model="detail.id_ahs"
                                item-text="status"
                                item-value="id_ahs"
                                :items="ahs"
                                @change="getSelectedIndex"
                                required 
                                disabled
                              ></v-select>
                            </v-flex>

                            <v-flex xs12 sm4 md4>
                              <v-select
                                label="Total" 
                                class="pa-1"
                                v-model="detail.id_ahs"
                                item-text="total"
                                item-value="id_ahs"
                                :items="ahs"
                                @change="getSelectedIndex"
                                required 
                                disabled
                              ></v-select>
                            </v-flex>

                            <v-flex>
                              <v-text-field
                                v-model="detail.volume"
                                label="Volume"
                                class="pa-1"
                              >
                              </v-text-field>
                            </v-flex>

                            <v-flex>
                              <v-text-field
                                v-model="detail.coefficient"
                                label="Coefficient*"
                                class="pa-1"
                              >
                              </v-text-field>
                            </v-flex>
                            </v-card-title>
                          </Vcard>
                        </v-flex>
                        
                        <V-layout v-if="tambah">
                            <VCard> 
                            <v-card-title>
                            <v-btn 
                                icon
                                color="red"
                                dark @click="tambah=false"
                                >
                                <v-icon>remove_circle</v-icon>
                            </v-btn>
                            <v-btn 
                                icon
                                color="green"
                                dark @click="addList()"
                                >
                                <v-icon>add_circle</v-icon>
                            </v-btn>

                            <v-flex>
                              <v-container row>
                                <v-select row
                                  v-model="rab_details.type"
                                  :items="type"
                                  item-text="name"
                                  item-value="name"
                                  label="Type of Task"
                                  required
                                ></v-select>
                                <v-btn 
                                  width="50px" 
                                  color="blue" 
                                  @click="dialog5=true"
                                > 
                                Add
                                </v-btn>
                              </v-container>
                            </v-flex>

                            <template>
                              <v-dialog v-model="dialog5" width="300px" style="color: blue">
                                <v-card-text>
                                  <v-layout>
                                    <v-text-field
                                      label="Type of Task"
                                      v-model="jenis">
                                    </v-text-field>
                                  </v-layout>
                                  <div class="flex-grow-1"></div>
                                    <v-btn class="ma-2" rounded color="green" dark @click="dialog5=false">Cancel</v-btn>
                                    <v-btn class="ma-2" rounded color="orange" dark @click="addTaskSub()">Save</v-btn>                  
                                </v-card-text>
                              </v-dialog>
                            </template>

                            <v-flex>
                              <v-select
                                label="AHS" 
                                class="pa-1"
                                v-model="AHS.id_ahs"
                                item-text="name"
                                item-value="id_ahs"
                                :items="ahs"
                                @change="getSelectedIndex"
                                required 
                              ></v-select>
                            </v-flex>

                            <v-flex xs12 sm4 md4>
                              <v-select
                                label="Status" 
                                class="pa-1"
                                v-model="AHS.id_ahs"
                                item-text="status"
                                item-value="id_ahs"
                                :items="ahs"
                                @change="getSelectedIndex"
                                disabled
                                required 
                              ></v-select>
                            </v-flex>

                            <v-flex xs12 sm4 md4>
                              <v-select
                                label="Total" 
                                class="pa-1"
                                v-model="AHS.id_ahs"
                                item-text="total"
                                item-value="id_ahs"
                                :items="ahs"
                                @change="getSelectedIndex"
                                disabled
                                required 
                              ></v-select>
                            </v-flex>

                            <v-flex>
                              <v-text-field
                                v-model="rab_details.volume"
                                label="Volume"
                                class="pa-1"
                              >
                              </v-text-field>
                            </v-flex>

                            <v-flex>
                              <v-text-field
                                v-model="rab_details.coefficient"
                                label="Coefficient*"
                                class="pa-1"
                              >
                              </v-text-field>
                            </v-flex>
                            </v-card-title>
                          </Vcard>
                        </v-layout>

                      <v-layout>
                        <v-flex>
                          <v-text-field
                            v-model="rab.total_rab"
                            label="Total RAB"
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout>
                        <v-text-field
                          v-model="rab.desc"
                          label="Description"
                          >
                        </v-text-field>
                      </v-layout>

                    </v-card-text>
                  </Vform>

                  <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn class="ma-2" rounded color="green" dark @click="close">Cancel</v-btn>
                    <v-btn class="ma-2" rounded color="orange" dark @click="updateItem(rab.id_rab)">Save</v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>

              <v-dialog v-model="dialog2" max-width="290px">
                <template v-slot:activator="{ on }">
                  <v-icon
                    small
                    color="red"
                    v-on="on"
                    @click="itemHandler2(item)"
                  >
                    delete
                  </v-icon>
                </template>
                    <v-card>
                      <v-card-title class="headline">Confirmation</v-card-title>
                        <v-card-text>Are you sure want to delete this AHS?</v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="green darken-1" text @click="dialog2 = false; deleteItem(rab.id_rab)">Yes</v-btn>
                        <v-btn color="red darken-1" text @click="dialog2 = false">No</v-btn>
                      </v-card-actions>
                    </v-card>
              </v-dialog>

              <v-icon
                small
                color="blue"
                @click="itemHandler(item)"
              >
                remove_red_eye
              </v-icon>
              </v-expansion-panel-header>
              
            </template>
            </v-data-table>
          
          <v-expansion-panel-content>
            <template>
              <div>
                <v-data-table
                  :headers="headers2"
                  :items="rab_details"
                  class="elevation-1"
                >
                <template v-slot:item.action="{ item }">
                  <v-dialog v-model="dialog5" max-width="500px">
                    <template v-slot:activator="{ on }">
                      <v-icon
                        small
                        class="mr-2"
                        color="green"
                        @click="itemDetailHandler(item)"
                        v-on="on"
                      >
                        edit
                      </v-icon>
                    </template>

                    <v-card>
                      <v-card-title>
                        <span class="headline">Edit Detail</span>
                      </v-card-title>
                  
                    <Vform> 
                      <v-card-text>
                        <v-layout>
                          <v-text-field
                            v-model="detail.volume"
                            label="Volume"
                          ></v-text-field>
                        </v-layout>

                        <v-layout>
                          <v-text-field
                            v-model="detail.coefficient"
                            label="Coefficient"
                            >
                          </v-text-field>
                        </v-layout>

                        <!-- <v-layout>
                          <v-text-field
                            v-model="detail.sub_total"
                            label="Sub Total"
                            >
                          </v-text-field>
                        </v-layout> -->

                      </v-card-text>
                    </Vform>

                      <v-card-actions>
                        <div class="flex-grow-1"></div>
                        <v-btn class="ma-2" rounded color="green" dark @click="close">Cancel</v-btn>
                        <v-btn class="ma-2" rounded color="orange" dark @click="updateDetail(detail.id_rab_details)">Save</v-btn>
                      </v-card-actions>
                    </v-card>
                  </v-dialog>
                  
                  <v-dialog v-model="dialog8" max-width="290px">
                    <template v-slot:activator="{ on }">
                      <v-icon
                        small
                        color="red"
                        v-on="on"
                        @click="itemDetailHandler(item)"
                      >
                        delete
                      </v-icon>
                    </template>
                        <v-card>
                          <v-card-title class="headline">Confirmation</v-card-title>
                            <v-card-text>Are you sure want to delete this detail?</v-card-text>
                          <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="green darken-1" text @click="dialog8 = false; deleteDetail(detail.id_rab_details)">Yes</v-btn>
                            <v-btn color="red darken-1" text @click="dialog8 = false">No</v-btn>
                          </v-card-actions>
                        </v-card>
                  </v-dialog>
                </template>

                </v-data-table>
              </div>
            </template>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
    </v-row>
  </div>
</template>

<script>
import Controller from './../service/Project'
import ahsController from './../service/AHS'
import rabController from './../service/RAB'

  export default {
    data: () => ({
      dialog: false,
      dialog2: false,
      dialog3: false,
      dialog4: false,
      dialog5: false,
      dialog6: false,
      dialog7: false,
      dialog8: false,
      menu: false,
      tambah: false,
      tambahS: false,
      tambahF: false,
      tambahT: false,

      select: null,
      search:'',
      jenis:'',
      sub_item: '',
      gedung:'',
      index: '',

      details:[],
      project: [],
      ahs: [],
      RAB:[],
      detailsData: [],

      Structure:[],
      structure:[],
      structure_data:{
        id_structure: '',
        name : '',
      },

      Groups:[],
      sub: [],
      group_data:{
        id_group: '',
        id_structure:'',
        name:'',
        concatenate:''
      },

      TaskSub:[],
      type:[],
      tasksub_data:{
        id_sub:'',
        name:'',
        concatenate:''
      },

      detail:{
        coefficient: '',
        volume:''
      },
      rab_details:{
        id_rab_details:'',
        id_rab:'',
        id_ahs:'',
        sub_total: 0,
        volume: 0,
        coefficient: 1,
        concatenate:'',
        hp: 0
      },
      Job:{
        id_job:''
      },
      AHS:{
        total:0,
        id_ahs:'',
        concatenate:''
      },
      rab:{
        id_rab:'',
        id_project:'',
        id_ahs:'',
        coefficient: 1,
        total_rab:0,
        kode:'',
        desc: '',
        sub:'',
      },
      Project: {
        name:'',
        date: new Date().toISOString().substr(0, 10),
        address: '',
        contact: '',
        id_project: '',
        phone: '',
      },
      headers: [
        {
          text: 'ID',
          align: 'left',
          sortable: false,
          value: 'kode',
        },
        {
          text: 'Project',
          sortable: false,
          value: 'name',
        },
        { 
          sortable: false,
          text: 'Nominal', 
          value: 'total_rab'
        },
        { 
          text: 'Actions', 
          value: 'action', 
          sortable: false 
        },
      ],
      headers2: [
        // { 
        //   text: 'ID AHS', align: 'left', sortable: false, value: 'kode_ahs',
        // },
        // { 
        //   text: 'Satuan', align: 'left', sortable: false, value: 'satuan',
        // },
        // {
        //   text: 'Status', align: 'left', sortable: false, value: 'status',
        // },
        // {
        //   text: 'Coefficient', align: 'left', sortable: false, value: 'coefficient'
        // },
        // { 
        //   text: 'Price', align: 'left', sortable: false, value: 'price',
        // },
        // { 
        //   text: 'Volume', align: 'left', sortable: false, value: 'volume',
        // },
        // { 
        //   text: 'Sub Total', align: 'left', sortable: false, value: 'sub_total',
        // },
        // {
        //   text: 'Actions', align: 'left', sortable: false, value: 'action'
        // },
      ],
    }),
    mounted(){
      this.getallDetails()
      this.getallItem()
      this.getallAHS()
      this.getallRAB()
      this.getGroup()
      this.getTaskSub()
      this.getStructure()
    },
    computed: {
      
    },
    methods: {
      itemHandler(item){
        this.rab_details = item.rab_details
        console.log(this.rab_details)
      },
      itemHandler2(item){
        this.rab = item
        this.details = item.rab_details.data
        // this.rab.total_rab = 0
        console.log(this.rab)
      },
      itemDetailHandler(item){
        this.detail = item
        console.log(this.detail)
      },
      async addstructure()
      {
        var i = 0
        this.err = false
        var object = this.structure_data
        let data = this.structure.find(obj=>obj.id_structure == this.structure_data.id_structure)
        console.log(data)
        object.id_structure = data.id_structure
        object.name = data.name
        this.Structure.push(JSON.parse(JSON.stringify(object)))
        console.log(this.Structure)
      },
      deletestructure(id){
        let data = this.Structure.find(obj=>obj.id_structure == id)
        let filter = this.Structure.filter(function( obj ) {
            return obj.id_structure !== id;
        });
        this.Structure=filter
      },
      async addfloor()
      {
        this.err = false
        var object = this.group_data
        let data = this.sub.find(obj=>obj.id_group == this.group_data.id_group)
        let dataS = this.Structure.find(obj=>obj.id_structure == this.group_data.id_structure)
        object.id_groups     = data.id_group
        object.id_structure = this.group_data.id_structure
        object.name         = data.name
        object.concatenate = dataS.name + '-' + object.name
        this.Groups.push(JSON.parse(JSON.stringify(object)))
        console.log(this.Groups)
      },
      deletefloor(id){
        let data = this.Groups.find(obj=>obj.id_group == id)
        let filter = this.Groups.filter(function( obj ) {
            return obj.id_group !== id;
        });
        this.Groups=filter
      },
      async addtasksub()
      {
        var i = 0
        this.err = false
        var object = this.tasksub_data
        let data = this.type.find(obj=>obj.id_sub == this.tasksub_data.id_sub)
        // let dataT = this.Groups.find(obj=>obj.id_group == this.group_data.id_group)
        //perlu nambahin id group
        object.id_sub = data.id_sub
        object.name = data.name
        object.concatenate = this.tasksub_data.concatenate
        object.concatenate_task = this.tasksub_data.concatenate + '-' + object.name
        this.TaskSub.push(JSON.parse(JSON.stringify(object)))
        console.log(this.TaskSub)
      },
      deletetasksub(id){
        let data = this.TaskSub.find(obj=>obj.id_sub == id)
        let filter = this.TaskSub.filter(function( obj ) {
            return obj.id_sub !== id;
        });
        this.TaskSub=filter
      },
      async addList()
      {
        var i = 0
        this.err = false
        var object = this.AHS
        let data = this.ahs.find(obj=>obj.id_ahs == this.AHS.id_ahs)
        object.id_ahs = this.ahs[this.index].id_ahs
        object.coefficient = this.rab_details.coefficient
        object.status = data.status
        object.concatenate = this.rab_details.concatenate
        if(object.status == 'Price')
        {
          object.volume = this.rab_details.volume
          object.sub_total  = object.coefficient * data.total
          this.rab_details.hp = object.sub_total * object.volume
        }
        else
        {
          object.volume = object.coefficient * this.rab_details.volume
          object.sub_total = data.total
          this.rab_details.hp = object.volume * object.sub_total
        }
        this.rab.total_rab = parseInt(this.rab_details.hp + this.rab.total_rab,10);
        this.rab.id_ahs = object.id_ahs
        this.details.push(JSON.parse(JSON.stringify(object)))
        this.tambah = false
        this.AHS.id_ahs=""
        console.log(this.details)
      },
      deleteList(id){
        let data = this.details.find(obj=>obj.id_ahs == id)
        this.rab.total_rab = parseInt(this.rab.total_rab - data.sub_total,10)
        console.log(this.rab.total_rab)
        let filter = this.details.filter(function( obj ) {
            return obj.id_ahs !== id;
        });
        this.details=filter
      },
      getSelectedIndexF(){
          this.index = this.sub.map(function(e) { return e.id_group; }).indexOf(this.group_data.id_group)
          console.log(this.index)
          console.log('masuk')
        },
      getSelectedIndex(){
        this.index = this.ahs.map(function(e) { return e.id_ahs; }).indexOf(this.AHS.id_ahs);
        console.log(this.index)
      },
      async addTaskSub()
      {
        try{
          const payload = {
            name :  'Pekerjaan' + ' ' + this.sub_item,
          }
          await rabController.addTaskSub(payload)
          this.getTaskSub()
          this.dialog5 = false
          this.sub_item = ''
        }catch(err){
          console.log(err)
        }
      },
      async getTaskSub(){
        try{
          this.type = (await rabController.getTaskSub()).data
        }catch(err){
          console.log(err)
        }
      },
      async getGroup(){
        try{
          this.sub = (await rabController.getGroup()).data
        }catch(err){
          console.log(err)
        }
      },
      async getallDetails(){
        try{
          this.detailsData = (await rabController.getallDetails()).data
        }catch(err){
          console.log(err)
        }
      },
      async getallAHS(){
        try{
          this.ahs = (await ahsController.getallItem()).data
        }catch(err){
          console.log(err)
        }
      },
      async getallItem(){
        try{
          this.project = (await Controller.getallItem()).data
        }catch(err){
          console.log(err)
        }
      },
      async getallRAB(){
        try{
          this.RAB = (await rabController.getallItem()).data
        }catch(err){
          console.log(err)
        }
      },
      async addGroup()
      {
        try{
          const payload = {
            name : 'Lantai' + ' ' + this.sub_item,
          }
          await rabController.addGroup(payload)
          this.getGroup()
          this.sub_item = ''
        }catch(err){
          console.log(err);
        }
      },
      async addAllItem(){
        try{
          const payload = {
            id_project        : this.rab.id_project,
            id_ahs            : this.rab.id_ahs,
            kode              : this.rab.kode,
            desc              : this.rab.desc,
            total_rab         : this.rab.total_rab,
            detail_structure  : this.Structure,
            detail_group      : this.Groups,
            detail_task       : this.TaskSub,
            detail            : this.details,
          }
          await rabController.addAllItem(payload)
          this.close()
          this.getallRAB()
          this.refresh()
        }catch(err){
          console.log(err);
        }
      },
      async updateItem(id){
        try{
            const payload = {
              id_project    : this.rab.id_project,
              id_ahs        : this.rab.id_ahs,
              kode          : this.rab.kode,
              sub           : this.rab.sub,
              desc          : this.rab.desc,
              total_rab     : this.rab.total_rab,
              detail        : this.details
            } 
            await rabController.updateItem(payload,id)
            this.getallRAB()
            this.close()
            this.refresh()
        }catch(err){
          console.log(err);
        }
      },
      async deleteItem(id){
        try{
          await rabController.deleteItem(id).data
          this.getallRAB()
          this.refresh()
        }catch(err){
          console.log(err)
        }
      },
      async deleteDetail(id){
        try{
          await rabController.deleteDetail(id).data
          this.getallDetails()
          this.getallRAB()
        }catch(err){
          console.log(err)
        }
      },
      async updateDetail(id){
        try{
          const payload = {
            coefficient   : this.detail.coefficient,
            volume        : this.detail.volume
          }
          await rabController.updateDetail(payload,id)
          this.getallDetails()
          this.getallRAB()
          this.close()
        }catch(err){
          console.log(err)
        }
      },
      async addStructure()
      {
        try{
          const payload = {
            name :  'Gedung' + ' ' + this.gedung,
          }
          await rabController.addStructure(payload)
          this.getStructure()
          this.gedung = ''
        }catch(err){
          console.log(err)
        }
      },
      async getStructure(){
        try{
          this.structure = (await rabController.getStructure()).data
        }catch(err){
          console.log(err)
        }
      },
      refresh(){
        this.deleteList()
        this.rab = ''
      },
      close () {
        this.dialog = false
        this.dialog3 = false
        this.dialog5 = false
        this.dialog6 = false
        this.dialog7 = false
        this.dialog8 = false
      },
    }
  }
</script>